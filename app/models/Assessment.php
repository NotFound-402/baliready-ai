<?php

class Assessment
{
    public int $id;
    public int $user_id;
    public array $answers = [];
    public string $created_at;
}
