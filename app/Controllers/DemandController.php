<?php

namespace App\Controllers;

use Core\Http\Controllers\Controller;
use Core\Http\Request;
use Lib\FlashMessage;

class DemandController extends Controller
{
    public function index(Request $request): void
    {
        $demands = $this->current_user->demands();

        $title = 'Demandas Atribuídas';

        if ($request->acceptJson()) {
            $this->renderJson('demands/index', compact('demands', 'demands', 'title'));
        } else {
            $this->render('demands/index', compact('demands', 'demands', 'title'));
        }

    }

    public function create(): void
    {
        $title = 'Criar Demanda';
        $this->render('demands/create', compact('title'));
    }

    public function store(Request $request): void
    {
        $params = $request->getParams();
        $demand = $this->current_user->demands()->new($params['demand']);
        if($demand->save()) {
            FlashMessage::success('Demanda criada com sucesso!');
            $this->redirectTo(route('demands.index'));
        } else {
            FlashMessage::danger('Existem dados incorretos! Por verifique!');
            $title = 'Criar Demanda';
            $this->render('demands/create', compact('demand', 'title'));
        }
    }

    public function edit(Request $request): void
    {
        $params = $request->getParams();
        $demand = $this->current_user->demands()->findById($params['id']);
        $title = 'Editar Demanda #' . $demand->id;
        $this->render('demands/edit', compact('title'));
    }

    public function update(Request $request): void
    {
        $params = $request->getParams();
        $demand = $this->current_user->demands()->findById($params['id']);
        $demand->fill($params['demand']);
        if($demand->save()) {
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
        $demand = $this->current_user->demands()->findById($params['id']);
        $title = 'Detalhes da Demanda #' . $demand->id;
        $this->render('demands/show', compact('title'));
    }

    public function destroy(Request $request): void
    {
        $params = $request->getParams();
        $demand = $this->current_user->demands()->findById($params['id']);
        if($demand->destroy()) {
            FlashMessage::success('Demanda excluída com sucesso!');
        } else {
            FlashMessage::danger('Erro ao excluir a demanda!');
        }
        $this->redirectTo(route('demands.index'));
    }

}
