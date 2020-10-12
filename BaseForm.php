<?php
/**
 * @author Basic App Dev Team <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\Form;

use BasicApp\HtmlHelper\HtmlHelper;
use BasicApp\UrlHelper\UrlHelper;
use CodeIgniter\Entity;

abstract class BaseForm
{

    protected $_errors = [];

    public $errorClass = 'is-invalid';

    public $formAttributes = [];

    public $hiddenAttributes = [];

    public $inputAttributes = [];

    public $passwordAttributes = [];

    public $uploadAttributes = [];

    public $multiselectAttributes = [];

    public $dropdownAttributes = [];

    public $checkboxAttributes = [];

    public $radioAttributes = [];

    public $submitAttributes = [];

    public $resetAttributes = [];

    public $buttonAttributes = [];

    public $labelAttributes = [];

    public $datalistAttributes = [];

    public $fieldsetAttributes = [];

    public function __construct(array $errors = [])
    {
        helper(['form']);

        $this->setErrors($errors);
    }

    public function cell($class, array $options = [])
    {
        return view_cell($class . '::render', $options = []);
    }

    public function getErrors() : array
    {
        return $this->_errors;
    }

    public function setErrors($errors, $merge = false)
    {
        if ($merge && $this->_errors)
        {
            $errors = array_merge($this->_errors, $errors);
        }

        $this->_errors = $errors;
    }

    public function getError(string $name, array $attributes = [])
    {
        if (array_key_exists('error', $attributes))
        {
            return $attributes['error'];
        }

        $errors = $this->getErrors();

        if (array_key_exists($name, $errors))
        {
            return $errors[$name];
        }

        return null;
    }    

    public function formatExtensions(string $accept)
    {
        $return = '';

        foreach(explode(',', $accept) as $ext)
        {
            $ext = ltrim($ext, '.');

            if ($return)
            {
                $return .= ', ';
            }

            $return .= '.' . trim($ext); 
        }

        return $return;
    }

    public function getValue($data, string $name, array $attributes = [], $default = '')
    {
        if (array_key_exists('value', $attributes))
        {
            return (string) $attributes['value'];
        }

        if (is_object($data))
        {
            if ($data instanceof Entity)
            {
                $return = $data->$name;

                if ($return !== null)
                {
                    return (string) $data->$name;
                }
            }

            if (method_exists($data, 'toArray'))
            {
                $data = $data->toArray();
            }
            else
            {
                $data = (array) $data;
            }
        }

        if (array_key_exists($name, $data))
        {
            return (string) $data[$name];
        }

        return (string) $default;
    }

    public function open($action = null, $attributes = [], array $hidden = []): string
    {
        if ($action === null)
        {
            $action = UrlHelper::currentUrl();
        }

        $attributes = HtmlHelper::mergeAttributes($this->formAttributes, $attributes);

        return form_open($action, $attributes, $hidden);
    }

    public function openMultipart($action = null, $attributes = [], array $hidden = []): string
    {
        if ($action === null)
        {
            $action = UrlHelper::currentUrl();
        }

        $attributes = HtmlHelper::mergeAttributes($this->formAttributes, $attributes);

        return form_open_multipart($action, $attributes, $hidden);
    }

    public function close(string $extra = ''): string
    {
        return form_close($extra);
    }

    public function hidden($data, $name, array $attributes = []): string
    {
        $value = $this->getValue($data, $name, $attributes);

        $attributes = HtmlHelper::mergeAttributes($this->hiddenAttributes, $attributes);

        if ($this->getError($name, $attributes))
        {
            $attributes = HtmlHelper::addClass($attributes, $this->errorClass);
        }

        return form_hidden($name, $value);
    }

    public function input($data, $name, array $attributes = []): string
    {
        if (array_key_exists('type', $attributes))
        {
            $type = $attributes['type'];

            unset($attributes['type']);
        }
        else
        {
            $type = 'text';
        }

        $value = $this->getValue($data, $name, $attributes);

        $attributes = HtmlHelper::mergeAttributes($this->inputAttributes, $attributes);

        if ($this->getError($name, $attributes))
        {
            $attributes = HtmlHelper::addClass($attributes, $this->errorClass);
        }

        return form_input($name, $value, $attributes, $type);
    }

    public function password($data, $name, array $attributes = []): string
    {
        $value = $this->getValue($data, $name, $attributes);

        $attributes = HtmlHelper::mergeAttributes($this->passwordAttributes, $attributes);

        if ($this->getError($name, $attributes))
        {
            $attributes = HtmlHelper::addClass($attributes, $this->errorClass);
        }

        return form_password($name, $value, $attributes);
    }

    public function upload($data, $name, array $attributes = []): string
    {
        if (array_key_exists('accept', $attributes))
        {
            $attributes['accept'] = $this->formatExtensions($attributes['accept']);
        }

        $value = $this->getValue($data, $name, $attributes);

        $attributes = HtmlHelper::mergeAttributes($this->uploadAttributes, $attributes);

        if ($this->getError($name, $attributes))
        {
            $attributes = HtmlHelper::addClass($attributes, $this->errorClass);
        }

        return form_upload($name, $value, $attributes);
    }    

    public function multiselect($data, $name, array $list = [], array $attributes = []): string
    {
        $value = $this->getValue($data, $name, $attributes);

        $attributes = HtmlHelper::mergeAttributes($this->multiselectAttributes, $attributes);

        if ($this->getError($name, $attributes))
        {
            $attributes = HtmlHelper::addClass($attributes, $this->errorClass);
        }

        return form_multiselect($name, $list, $value, $attributes);
    }

    public function dropdown($data, $name, $list = [], array $attributes = []): string
    {
        $value = $this->getValue($data, $name, $attributes);

        $attributes = HtmlHelper::mergeAttributes($this->dropdownAttributes, $attributes);

        if ($this->getError($name, $attributes))
        {
            $attributes = HtmlHelper::addClass($attributes, $this->errorClass);
        }

        return form_dropdown($name, $list, $value, $attributes);
    }    

    public function checkbox($data, $name, $value = 1, array $attributes = []): string
    {
        $currentValue = $this->getValue($data, $name, $attributes);

        if (is_array($currentValue))
        {
            if (array_search($value, $currentValue) !== false)
            {
                $checked = true;
            }
            else
            {
                $checked = false;
            }
        }
        else
        {
            if ($currentValue == $value)
            {
                $checked = true;
            }
            else
            {
                $checked = false;
            }
        }

        $uncheckValue = '0';

        if (array_key_exists('uncheckValue', $attributes))
        {
            $uncheckValue = (string) $attributes['uncheckValue'];
        }

        if ($uncheckValue || ($uncheckValue === '0'))
        {
            $uncheck = form_hidden($name, $uncheckValue);
        }
        else
        {
            $uncheck = '';
        }

        $attributes = HtmlHelper::mergeAttributes($this->checkboxAttributes, $attributes);

        if ($this->getError($name, $attributes))
        {
            $attributes = HtmlHelper::addClass($attributes, $this->errorClass);
        }

        return $uncheck . form_checkbox($name, (string) $value, $checked, $attributes);
    }    

    public function radio($data, $name, string $value, array $attributes = []): string
    {
        if ($this->getValue($data, $name, $attributes) == $value)
        {
            $checked = true;
        }
        else
        {
            $checked = false;
        }

        $attributes = HtmlHelper::mergeAttributes($this->radioAttributes, $attributes);

        if ($this->getError($name, $attributes))
        {
            $attributes = HtmlHelper::addClass($attributes, $this->errorClass);
        }

        return form_radio($name, $value, $checked, $attributes);
    }

    public function submit($name, $value, array $attributes = []): string
    {
        $attributes = HtmlHelper::mergeAttributes($this->submitAttributes, $attributes);

        if ($this->getError($name, $attributes))
        {
            $attributes = HtmlHelper::addClass($attributes, $this->errorClass);
        }

        return form_submit($name, $value, $attributes);
    }

    public function reset($name, $value, array $attributes = []): string
    {
        $attributes = HtmlHelper::mergeAttributes($this->resetAttributes, $attributes);   

        if ($this->getError($name, $attributes))
        {
            $attributes = HtmlHelper::addClass($attributes, $this->errorClass);
        }

        return form_reset($name, $value, $attributes);
    }

    public function button($name, $value, array $attributes = []): string
    {
        $attributes = HtmlHelper::mergeAttributes($this->buttonAttributes, $attributes);

        if ($this->getError($name, $attributes))
        {
            $attributes = HtmlHelper::addClass($attributes, $this->errorClass);
        }

        return form_button($name, $value, $attributes);
    }    

    public function label(string $label = '', array $attributes = []): string
    {
        if (array_key_exists('id', $attributes))
        {
            $id = $attributes['id'];
        }
        else
        {
            $id = '';
        }

        $attributes = HtmlHelper::mergeAttributes($this->labelAttributes, $attributes);

        if ($this->getError($name, $attributes))
        {
            $attributes = HtmlHelper::addClass($attributes, $this->errorClass);
        }

        return form_label($label, $id, $attributes);
    }

    public function datalist($data, $name, array $attributes = []): string
    {
        $value = $this->getValue($data, $name, $attributes);

        $attributes = HtmlHelper::mergeAttributes($this->datalistAttributes, $attributes);
   
        if ($this->getError($name, $attributes))
        {
            $attributes = HtmlHelper::addClass($attributes, $this->errorClass);
        }

        return form_datalist($name, $value, $attributes);
    }

    public function fieldset($label = '', array $attributes = []): string
    {
        $attributes = HtmlHelper::mergeAttributes($this->fieldsetAttributes, $attributes);

        if ($this->getError($name, $attributes))
        {
            $attributes = HtmlHelper::addClass($attributes, $this->errorClass);
        }

        return form_fieldset($label, $attributes);
    }

    public function fieldsetClose(): string
    {
        return form_fieldset_close();
    }

}