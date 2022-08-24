<?php

$senhaCrip = password_hash('aluno123',PASSWORD_BCRYPT,['cost' => 12]);
echo $senhaCrip;
echo '<hr>';

var_dump(password_verify('aluno123',$senhaCrip));