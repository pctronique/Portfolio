<?php
if (!enum_exists(Enum_Type::class)) {
    enum Enum_Type
    {
        case PRODUITS;
        case CATEGORIE;
        case LOGO;
        case USER;
    }
}
