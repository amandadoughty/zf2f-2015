<?php
namespace Market\Form;


use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Input;
use Zend\Filter\StripTags;
use Zend\Filter\StringTrim;
use Zend\Filter\StringToLower;
use Zend\Validator\InArray;
use Zend\Validator\StringLength;
use Zend\I18n\Validator\Alnum;

class PostFilter extends InputFilter
{
    protected $categories;
    
    public function buildFilter()
    {
        
        $category = new Input('category');
        $category->getFilterChain()
                 ->attach(new StringTrim())
                 ->attach(new StripTags())
                 ->attach(new StringToLower());
         $category->getValidatorChain()
                 ->attach(new InArray(['haystack' => $this->categories])); 
               
        $title = new Input('title');
        $title->getFilterChain()
                ->attach(new StringTrim())
                ->attach(new StripTags());
        $title->getValidatorChain()
              ->attach(new StringLength(['min' => 1, 'max' => 128]))
              ->attach(new Alnum(['allowWhiteSpace' => TRUE]));
        
        $this->add($category)
             ->add($title);
        
    }
    
	/**
     * @return the $categories     */
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