<?php

namespace App;

enum UserRole: string
{
    case penerima = "penerima";
    case penyedia = "Penyedia";
    case admin = "admin";
}
