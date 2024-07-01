<?php

require __DIR__ . '/../../config/bootstrap.php';

use Core\Database\Database;
use Database\Populate\ProfilePopulate;
use Database\Populate\StatusPopulate;
use Database\Populate\UsersPopulate;

Database::migrate();

UsersPopulate::populate();
ProfilePopulate::populate();
StatusPopulate::populate();
