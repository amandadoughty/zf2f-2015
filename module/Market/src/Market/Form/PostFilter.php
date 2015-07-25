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
    protected $expireDays;
    protected $cities;
        
    public function buildFilter()
    {

		$expireList = array_keys($this->expireDays);
		$cityList = array_keys($this->cities);
        
        $category = new Input('category');
        $notEmpty = new Validator\NotEmpty();
        $notEmpty->setMessage('Need to supply a value');
        $category->getValidatorChain()
                 ->attach($notEmpty)
                 ->attach(new Validator\InArray(['haystack' => $this->categories]));
                
        $title = new Input('title'); 
        $title->getValidatorChain()
              ->attach(new Validator\NotEmpty())
              ->attach(new Alnum(['allowWhiteSpace' => TRUE]))
              ->attach(new Validator\StringLength(['min' => 1, 'max' => 128]));        
        
		// used for InArray validators
		
		$photo = new Input('photoFilename');
		$photo->getFilterChain()
				 ->attachByName('StripTags')
				 ->attachByName('StringTrim');
		$photo->getValidatorChain()
			  ->attachByName('Regex', ['pattern' => '!^(http(s)?://)?[a-z0-9./_-]+(jpg|png)$!i']);
		$photo->setErrorMessage('Photo must be a URL or a valid filename ending with jpg or png');

        $callback = function ($value) { return (float) $value; };
		$price = new Input('price');
		$price->setAllowEmpty(TRUE);
		$price->getValidatorChain()
			  ->addByName('GreaterThan', ['min' => 0]);
		$price->getFilterChain()
			  ->attach(new Filter\Callback($callback));

		$expires = new Input('expires');
		$expires->setAllowEmpty(TRUE);
		$expires->getValidatorChain()
				->attachByName('InArray', ['haystack' => $expireList]);
		
		$city = new Input('cityCountry');
		$city->setAllowEmpty(TRUE);
		$city->getValidatorChain()
			 ->attachByName('InArray', ['haystack' => $cityList]);
		
		$name = new Input('contactName');
		$name->setAllowEmpty(TRUE);
		$name->getValidatorChain()
			  ->attachByName('Regex', ['pattern' => '/^[a-z0-9., -]{1,255}$/i']);
		$name->setErrorMessage('Name should only contain letters, numbers, and some punctuation.');
  
		$phone = new Input('contactPhone');
		$phone->setAllowEmpty(TRUE);
		$phone->getValidatorChain()
			  ->attachByName('Regex', ['pattern' => '/^\+?\d{1,4}(-\d{3,4})+$/']);
		$phone->setErrorMessage('Phone number must be in this format: +nnnn-nnn-nnn-nnnn');
  
		$email = new Input('contactEmail');
		$email->setAllowEmpty(TRUE);
		$email->getValidatorChain()
			  ->attachByName('EmailAddress');
		
		$description = new Input('description');
		$description->setAllowEmpty(TRUE);
		$description->getValidatorChain()
					->attachByName('StringLength', ['min' => 1, 'max' => 4096]);
  
		$this->add($category)
			 ->add($title)
			 ->add($photo)
			 ->add($price)
			 ->add($expires)
			 ->add($city)
			 ->add($name)
			 ->add($phone)
			 ->add($email)
			 ->add($description);
             
        // globally apply StripTags and StringTrim
        $tags = new Filter\StripTags();
        $trim = new Filter\StringTrim();
        foreach ($this->getInputs() as $input) {
            $input->getFilterChain()->attach($tags)->attach($trim);
        }
        
    }
    
    public function getCategories()
    {
        return $this->categories;
    }

    public function setCategories($categories)
    {
        $this->categories = $categories;
    }

    public function getExpireDays()
    {
        return $this->expireDays;
    }

    public function setExpireDays($expireDays)
    {
        $this->expireDays = $expireDays;
    }

    public function getCities()
    {
        return $this->cities;
    }

    public function setCities($cities)
    {
        $this->cities = $cities;
    }

}
