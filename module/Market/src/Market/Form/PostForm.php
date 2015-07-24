<?php
namespace Market\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Zend\Captcha;

class PostForm extends Form
{
    protected $categories;
    protected $expireDays;
    protected $cities;
    protected $captchaOptions;
    
    public function buildForm()
    {
        $this->setAttribute('method', 'post');
        
        $category = new Element\Select('category');
        $category->setLabel('Category')
                 ->setAttribute('id', 'category')
                 ->setValueOptions(array_combine($this->getCategories(),$this->getCategories()))
                 ->setEmptyOption('Choose');
        
        $title = new Element\Text('title');
        $title->setLabel('Title')
              ->setAttribute('id', 'title')
              ->setAttribute('class', 'titleClass')
              ->setAttribute('placeholder', 'Please enter a title');
        
		$photo = new Element\Text('photo_filename');
		$photo->setLabel('Photo')
			  ->setAttribute('maxlength', 256);
		
		$price = new Element\Text('price');
		$price->setLabel('Price')
			  	 ->setAttribute('title', 'Enter price as nnn.nn')
	 		  	 ->setAttribute('size', 16)
			  	 ->setAttribute('maxlength', 16);
		
		$expires = new Element\Radio('expires');
		$expires->setLabel('Expires')
			    ->setAttribute('title', 'The expiration date will be calculated from today')
			    ->setAttribute('class', 'expiresButton')
			    ->setValueOptions($this->expireDays)
                ->setValue(0);
		
		$city = new Element\Select('city');
		$city->setLabel('Nearest City')
			  ->setAttribute('title', 'Select the city of the item')
			  ->setValueOptions($this->cities)
              ->setEmptyOption('Choose');
				
		$name = new Element\Text('contact_name');
		$name->setLabel('Contact Name')
			 ->setAttribute('title', 'Enter the name of the person to contact for this item')
			 ->setAttribute('size', 40)
			 ->setAttribute('maxlength', 255);
		
		$phone = new Element\Text('contact_phone');
		$phone->setLabel('Contact Phone Number')
			  ->setAttribute('title', 'Enter the phone number of the person to contact for this item')
			  ->setAttribute('size', 20)
			  ->setAttribute('maxlength', 32);
		
		$email = new Element\Email('contact_email');
		$email->setLabel('Contact Email')
			  ->setAttribute('title', 'Enter the email address of the person to contact for this item')
			  ->setAttribute('size', 40)
			  ->setAttribute('maxlength', 255);

		$description = new Element\Textarea('description');
		$description->setLabel('Description')
					->setAttribute('title', 'Enter a suitable description for this posting')
					->setAttribute('rows', 4)
					->setAttribute('cols', 80);

		$captcha = new Element\Captcha('captcha');
		$captchaAdapter = new Captcha\Image();
		$captchaAdapter->setWordlen(4)
					   ->setOptions($this->captchaOptions);		
		$captcha->setCaptcha($captchaAdapter)
				->setLabel('Help us to prevent SPAM!')
				->setAttribute('class', 'captchaStyle')
			    ->setAttribute('title', 'Help to prevent SPAM');
		
		$submit = new Element\Submit('submit');
		$submit->setAttribute('value', 'Post')
				->setAttribute('class', 'submitButton')
				->setAttribute('title', 'Click here when done');
		
		$this->add($category)
			 ->add($title)
			 ->add($photo)
			 ->add($price)
			 ->add($expires)
			 ->add($city)
			 ->add($name)
			 ->add($phone)
			 ->add($email)
			 ->add($description)
			 ->add($captcha)
			 ->add($submit);
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

    public function getCaptchaOptions()
    {
        return $this->captchaOptions;
    }

    public function setCaptchaOptions($captchaOptions)
    {
        $this->captchaOptions = $captchaOptions;
    }
    
}
