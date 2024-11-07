<?php

    namespace App\View\Components;

    use Illuminate\View\Component;

    class EmailDetailModal extends Component
    {
        public $email;

        /**
         * Create a new component instance.
         *
         * @return void
         */
        public function __construct($email)
        {
            $this->email = $email;
        }

        /**
         * Get the view / contents that represent the component.
         *
         * @return \Illuminate\View\View|string
         */
        public function render()
        {
            return view('components.email-detail-modal');
        }
    }
