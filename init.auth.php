<?php
// get authenticated user and the session
\App\App::initWebSession();
$_user = \App\App::getAuthenticatedUser();