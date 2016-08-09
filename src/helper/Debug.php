<?php

    /**
     * @param $prItem
     */
    function pre_print_r ($prItem)
    {

        print('<pre>');
            print_r($prItem);
        print('</pre>');

    }

    /**
     *
     * @param $prItem
     */
    function pre_var_dump ($prItem)
    {

        print('<pre>');
            var_dump($prItem);
        print('</pre>');

    }