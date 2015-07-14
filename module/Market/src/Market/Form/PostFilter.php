<?php
namespace Market\Form;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Input;
use Zend\Validator;
use Zend\Filter;
use Zend\I18n\Validator\Alnum;

class PostFilter extends InputFilter
{

    protected $categories;
        
    public function buildFilter()
    {
        // TODO: 
        /*
         * 1. Create Input objects
         * 2. For each: attach or attachByName filters & validators
         * 3. Add to this class
         */
        $category = new Input('category');
        $notEmpty = new Validator\NotEmpty();
        $notEmpty->setMessage('Need to supply a value');
        $category->getValidatorChain()
                 ->attach($notEmpty)
                 ->attach(new Validator\InArray(['haystack' => $this->categories]));
        $category->getFilterChain()
                 ->attach(new Filter\StripTags())
                 ->attach(new Filter\StringTrim());
                
        $title = new Input('title'); 
        $title->getValidatorChain()
              ->attach(new Validator\NotEmpty())
              ->attach(new Alnum(['allowWhiteSpace' => TRUE]))
              ->attach(new Validator\StringLength(['min' => 1, 'max' => 128]));        
        $title->getFilterChain()
              ->attach(new Filter\StripTags())
              ->attach(new Filter\StringTrim());
        
        $this->add($category)
             ->add($title);
    }
    
	/**
     * @return the $categories
     */
    public function getCategories()
    {
        return $this->categories;
    }

	/**
     * @param field_type $categories
     */
    public function setCategories($categories)
    {
        $this->categories = $categories;
    }

}
