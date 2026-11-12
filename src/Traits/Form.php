<?php
/**
 * @author Basic App Dev Team
 * @license MIT
 */
namespace BasicApp\Form\Traits;

trait Form
{
    use Labels;

    abstract public function fill(array $params);

    public function save(&$errors = null) : bool
    {
        return true;
    }

    public function rules() : array
    {
        return [];
    }
}