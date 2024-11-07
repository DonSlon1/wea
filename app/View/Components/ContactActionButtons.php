<?php

    namespace App\View\Components;

    use Illuminate\View\Component;

    class ContactActionButtons extends Component
    {
        public $contact;

        /**
         * Create a new component instance.
         *
         * @return void
         */
        public function __construct($contact)
        {
            $this->contact = $contact;
        }

        /**
         * Get the view / contents that represent the component.
         *
         * @return \Illuminate\View\View|string
         */
        public function render()
        {
            return view('components.contact-action-buttons');
        }
    }
