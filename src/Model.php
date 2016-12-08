<?php
    namespace Parvus;

    class Model extends \Illuminate\Database\Eloquent\Model
    {
        protected $primaryKey = 'id';
        public $timestamps = false;

        public function __construct()
        {

            parent::__construct();
            parent::boot();

            /** When save, remove NULL fields */
            static::saving(function($model)
            {

                foreach ($model->toArray() as $name => $value)
                {

                    if ((string) $value == NULL)
                    {

                        $model->{$name} = null;

                    }

                }

                return true;

            });

        }

        /**
         * Save a array
         * @param $prArray
         */
        public final function saveArray ($prArray)
        {

            foreach ($prArray as $label => $value)
            {

                $this->{$label} = $value;

            }

            $this->save();

        }

    }