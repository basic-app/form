<?php
/**
 * @author Basic App Dev Team <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\Form;

class FormGroup extends \BasicApp\Cell\BaseCell
{

    protected $form;

    public $label;

    public $hint;

    public $error;

    public $content;

    public function __construct(Form $form, array $properties = [])
    {
        parent::__construct($properties);

        $this->form = $form;

        //$this->setProperties($properties);
    }

    /*
    public function setProperties(array $properties = [])
    {
        foreach($properties as $key => $value)
        {
            if (property_exists($this, $key))
            {
                $this->$key = $value;
            }
            else
            {
                throw new FormException('Unknown property: ' . $key);
            }
        }
    }
    */

    public function render(array $params = [])
    {
        if (!array_key_exists('label', $params))
        {
            $params['label'] = $this->label;
        }
        
        if (!array_key_exists('hint', $params))
        {
            $params['hint'] = $this->hint;
        }

        if (!array_key_exists('error', $params))
        {
            $params['error'] = $this->error;
        }

        if (!array_key_exists('content', $params))
        {
            $params['content'] = $this->content;
        }

        return $this->view('form-group', $params);
    }

    public function hidden($data, $name, array $attributes = []): string
    {
        return $this->render([
            'content' => $this->form->hidden($data, $name, $attributes),
            'error' => $this->form->getError($name, $attributes)
        ]);
    }

    public function input($data, $name, array $attributes = []): string
    {
        return $this->render([
            'content' => $this->form->input($data, $name, $attributes),
            'error' => $this->form->getError($name, $attributes)
        ]);        
    }

    public function password($data, $name, array $attributes = []): string
    {
        return $this->render([
            'content' => $this->form->password($data, $name, $attributes),
            'error' => $this->form->getError($name, $attributes)
        ]);        
    }

    public function upload($data, $name, array $attributes = []): string
    {
        return $this->render([
            'content' => $this->form->upload($data, $name, $attributes),
            'error' => $this->form->getError($name, $attributes)
        ]);        
    }

    public function multiselect($data, $name, array $list = [], array $attributes = []): string
    {
        return $this->render([
            'content' => $this->form->multiselect($data, $name, $list, $attributes),
            'error' => $this->form->getError($name, $attributes)
        ]);        
    }

    public function dropdown($data, $name, $list = [], array $attributes = []): string
    {
        return $this->render([
            'content' => $this->form->dropdown($data, $name, $list, $attributes),
            'error' => $this->form->getError($name, $attributes)
        ]);        
    }

    public function checkbox($data, $name, $value = 1, array $attributes = []): string
    {
        return $this->render([
            'content' => $this->form->checkbox($data, $name, $value, $attributes),
            'error' => $this->form->getError($name, $attributes)
        ]);        
    }

    public function radio($data, $name, string $value, array $attributes = []): string
    {
        return $this->render([
            'content' => $this->form->radio($data, $name, $value, $attributes),
            'error' => $this->form->getError($name, $attributes)
        ]);        
    }

    public function submit($name, $value, array $attributes = []): string
    {
        return $this->render([
            'content' => $this->form->submit($data, $value, $attributes),
            'error' => $this->form->getError($name, $attributes)
        ]);        
    }

    public function reset($name, $value, array $attributes = []): string
    {
        return $this->render([
            'content' => $this->form->reset($data, $value, $attributes),
            'error' => $this->form->getError($name, $attributes)
        ]);        
    }

    public function button($name, $value, array $attributes = []): string
    {
        return $this->render([
            'content' => $this->form->button($data, $value, $attributes),
            'error' => $this->form->getError($name, $attributes)
        ]);        
    }

    public function label(string $label = '', array $attributes = []): string
    {
        return $this->render([
            'content' => $this->form->label($label, $attributes),
            'error' => $this->form->getError($name, $attributes)
        ]);        
    }

    public function datalist($data, $name, array $attributes = []): string
    {
        return $this->render([
            'content' => $this->form->datalist($data, $name, $attributes),
            'error' => $this->form->getError($name, $attributes)
        ]);        
    }

    public function fieldset($label = '', array $attributes = []): string
    {
        return $this->render([
            'content' => $this->form->fieldset($label, $attributes),
            'error' => $this->form->getError($name, $attributes)
        ]);        
    }

    public function fieldsetClose(): string
    {
        return $this->render([
            'content' => $this->form->fieldsetClose()
        ]);
    }

}