<?php namespace Sentinel\Services\Validation;

use Illuminate\Validation\Factory;
use Sentinel\Exceptions\FormValidationFailedException;

/**
 * Class FormValidator
 *
 * Borrowed from https://github.com/SRLabs/Laravel-Form-Validator
 *
 * @package Sentinel\Services\Validation
 */

abstract class FormValidator {

    protected $rules;
    protected $messages;
    protected $errors;
    protected $validator;

    public function __construct(Factory $validator)
    {
        $this->validator = $validator;
    }

    public function validate($input, $object = NULL)
    {
        // Has an object been passed to us as well as the input?
        if ($object)
        {
            $this->updateUniqueRules($object);
        }

        // Create the Validator Instance
        $validator = $this->validator->make($input, $this->getRules(), $this->getMessages());

        // Stop. Validate and listen.
        if ($validator->fails())
        {
            $this->errors = $validator->messages();
            throw new FormValidationFailedException('Form Validation Failed', $this->getErrors());
        }

        return true;
    }

    /**
     * @return mixed
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @param mixed $errors
     */
    public function setErrors($errors)
    {
        $this->errors = $errors;
    }

    /**
     * @return mixed
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * @param mixed $messages
     */
    public function setMessages($messages)
    {
        $this->messages = $messages;
    }

    /**
     * @return mixed
     */
    public function getRules()
    {
        return $this->rules;
    }

    /**
     * @param mixed $rules
     */
    public function setRules($rules)
    {
        $this->rules = $rules;
    }

    protected function updateUniqueRules($object)
    {
        // Check to see if there is a 'unique' rule specified in the rules array.
        foreach ($this->rules as $field => $list) {
            $this->rules[$field] = $this->updateRuleString($field, $list, $object);
        }
    }

    /**
     * @param $list
     */
    protected function updateRuleString($field, $list, $object)
    {
        $pos1 = strpos($list, 'unique');

        if ($pos1 !== false) {
            // There is a unique rule specified for this field.
            $pos2 = strpos($list, '|', $pos1);
            $beginning = substr($list, 0, $pos1);
            $ending = '';
            $table = $object->getTable();
            $id = $object->id;

            if ($pos2 !== false) {
                // There are more rules listed after the unique rule
                $ending = substr($list, $pos2);
                $length = abs($pos1 - $pos2);
                $unique = substr($list, $pos1, $length);
            } else {
                // The unique rule is the last rule listed for this field.
                $unique = substr($list, $pos1);
            }

            // Break the unique rule down into its corresponding components.
            $breakout = explode(':', $unique);

            $extras = (count($breakout) > 1 ? explode(',', $breakout[1]) : array(''));

            if ( ! empty( array_values( array_filter( $extras ) ) ) )
            {
                // There were extra values provided with this unique rule
                $breakout = array_merge(array($breakout[0]), $extras);
            }
            else
            {
                // There were no extra values provided with this unique rule
                // Remove the empty element from the end of the row
                $breakout = array_filter($breakout);
            }

            // Build up the new unique rule with all the knowledge we have gathered.
            switch (count($breakout))
            {
                case 1:
                    $unique = $breakout[0] . ':' . $table . ',' . $field . ',' . $id;
                    break;

                case 2:
                    $unique = $breakout[0] . ':' . $breakout[1] . ',' . $field . ',' . $id;
                    break;

                case 3:
                    $unique = $breakout[0] . ':' . $breakout[1] . ',' . $breakout[2] . ',' . $id;
                    break;

                default:
                    // Do nothing
                    break;
            }
        }
        else
        {
            // There is no unique rule associated with this field.
            return $list;
        }

        return $beginning . $unique . $ending;
    }

}