<?php
namespace Market\Form;

use Zend\Form\Form;
use Zend\Form\Element\Select;
use Zend\Form\Element\Text;
use Zend\Form\Element\Submit;

class PostForm extends Form
{
    protected $categories;
    
    public function buildForm()
    {
        
        $this->setAttribute('method', 'post');
        
        $category = new Select('category');
        $category->setLabel('Category')
                 ->setAttribute('title', 'Please select one of these categories')
                 ->setValueOptions(array_combine($this->getCategories(),$this->getCategories()));
        
        $title = new Text('title');
        $title->setLabel('Title')
              ->setAttribute('placeholder', 'Enter a Title for this Posting');
        
        $submit = new Submit('submit');
        $submit->setAttribute('value', 'Post');
        
        $this->add($category)
             ->add($title)
             ->add($submit);
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