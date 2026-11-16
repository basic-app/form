<?php

declare(strict_types=1);
/**
 * @author Basic App Dev Team
 * @license MIT
 */

namespace BasicApp\Form\Traits;

trait Labels
{
    public function labels(): array
    {
        return array_combine(
            $keys = array_keys($rules = $this->rules()),
            array_map(
                function ($key, $value) {
                    return lang($value['label'] ?? $key);
                },
                $keys,
                array_values($rules)
            )
        );
    }
}
