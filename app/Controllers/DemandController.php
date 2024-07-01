<?php

namespace App\Controllers;

use App\Models\Demand;
use App\Models\DemandUser;
use App\Models\Status;
use App\Models\User;
use Core\Http\Controllers\Controller;
use Core\Http\Request;
use Lib\FlashMessage;

class DemandController extends Controller
{
    public function index(Request $request): void
    {
        $user = $this->current_user->permissions();
        if($user->show_all_demands) {
            $demands = Demand::all();
        } else {
            $demands = $this->current_user->demands();
        }

        $statuses = Status::all();
        $statusMap = [];
        foreach ($statuses as $status) {
          $statusMap[$status->id] = $status;
        }

        $title = 'Demandas Atribuídas';

        if ($request->acceptJson()) {
            $this->renderJson('demands/index', compact('demands','user', 'demands', 'statusMap', 'title'));
        } else {
            $this->render('demands/index', compact('demands', 'user','demands', 'statusMap', 'title'));
        }

    }

    public function create(): void
    {
        $user = $this->current_user;
        $demand = new Demand();
        $demand->status_id = 1;

        $users = User::availableUsers();
        $statuses = Status::all();
        $title = 'Criar Demanda';
        $this->render('demands/create', compact('demand','user','users','statuses','title'));
    }

  public function store(Request $request): void
  {
    $params = $request->getParams();

    $demand = new Demand();
    $this->fillParams($params['demand'], $demand);
    $demand->id_user_created =  $this->current_user->id;

    if ($demand->save()) {
      // Obtenha os IDs dos usuários atribuídos
      $userIds = $params['demand']['user_id'] ?? [];
      foreach ($userIds as $userId) {
        $demandUser = new DemandUser();
        $demandUser->demand_id = $demand->id;
        $demandUser->user_id =  (int) $userId;
        $demandUser->status_id = 1;
        $demandUser->id_user_created = $this->current_user->id;
        $demandUser->save();
      }

      FlashMessage::success('Demanda criada com sucesso!');
      $this->redirectTo(route('demands.index'));
    } else {
      // Mensagem de erro
      FlashMessage::danger('Existem dados incorretos! Por favor, verifique!');
      $this->create();
    }
  }

    public function edit(Request $request): void
    {
        $user = $this->current_user->permissions();
        $params = $request->getParams();
        $demand = Demand::findById($params['id']);
        if($user->edit_status) {
            $demand_user = DemandUser::where(['demand_id' => $demand->id, 'user_id' => $this->current_user->id])[0];
            $demand->status_id = Status::findById($demand_user->status_id)->id;
        }$users_available = User::availableUsers();
        $users = $demand->usersDemand()->get();
        $users = array_map(function($user) {
          return $user->id;
        }, $users);
        $statuses = Status::all();
        $statusMap = [];
        foreach ($statuses as $status) {
          $statusMap[$status->id] = $status;
        }

        $title = 'Editar Demanda #' . $demand->id;
        $this->render('demands/edit', compact('demand', 'user', 'users', 'users_available','statuses', 'statusMap','title'));
    }

    public function update(Request $request): void
    {
      $params = $request->getParams();
      $demand = Demand::findById($params['id']);

      if($this->current_user->permissions()->edit_status) {
        $demandUser = DemandUser::where(['demand_id' => $demand->id, 'user_id' => $this->current_user->id])[0];
        $demandUser->status_id = (int) $params['demand']['status_id'];
        $demandUser->save();
        FlashMessage::success('Status da demanda atualizado com sucesso!');
        $this->redirectTo(route('demands.index'));
        return;
      }

      $this->fillParams($params['demand'], $demand);

      $demand->id_user_updated =  $this->current_user->id;
        if($demand->save()) {
          $users = $demand->usersDemand()->get();
          $users = array_map(function($user) {
            return $user->id;
          }, $users);

          // Remova todos os usuários atribuídos
          foreach ($users as $user) {
            $demandUser = DemandUser::where(['demand_id' => $demand->id, 'user_id' => $user]);
            $demandUser[0]->destroy();
          }

          // Obtenha os IDs dos usuários atribuídos
          $userIds = $params['demand']['users'] ?? [];
          foreach ($userIds as $userId) {
            $demandUser = new DemandUser();
            $demandUser->demand_id = $demand->id;
            $demandUser->user_id =  (int) $userId;
            $demandUser->status_id = 1;
            $demandUser->id_user_created = $this->current_user->id;
            $demandUser->save();
          }
            FlashMessage::success('Demanda atualizada com sucesso!');
            $this->redirectTo(route('demands.index'));
        } else {
            FlashMessage::danger('Existem dados incorretos! Por verifique!');
            $title = 'Editar Demanda #' . $demand->id;
            $this->render('demands/edit', compact('demand', 'title'));
        }
    }

    public function show(Request $request): void
    {
        $params = $request->getParams();
        $title = 'Detalhes da Demanda #';
        $this->render('demands/show', compact('title'));
    }

    public function destroy(Request $request): void
    {
        $params = $request->getParams();
        $demand = Demand::findById($params['id']);
        if($demand->destroy()) {
            FlashMessage::success('Demanda excluída com sucesso!');
        } else {
            FlashMessage::danger('Erro ao excluir a demanda!');
        }
        $this->redirectTo(route('demands.index'));
    }

  /**
   * @param $demand1
   * @param Demand|null $demand
   * @return void
   */
  public function fillParams($demand1, ?Demand $demand): void
  {
    $demand->title = $demand1['title'];
    $demand->expected_date = $demand1['expected_date'];
    $demand->path_image = $demand1['path_image'];
    $demand->description = $demand1['description'];
    $demand->status_id = $demand1['status_id'];
  }

}
