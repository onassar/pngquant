<?php

    // Writable check
    if (is_writable(__DIR__) === false) {
        throw new Exception(
            '*' . __DIR__ . '* needs to be writable'
        );
    }

    // Executable check
    if (is_file(__DIR__ . '/pngquant') === false) {
        throw new Exception(
            'Run `make` in *' . __DIR__ . '* first'
        );
    }

    /**
     * PngQuant
     * 
     * @author  Oliver Nassar <onassar@gmail.com>
     * @see     <https://github.com/onassar/pngquant>
     * @see     <https://github.com/pornel/pngquant>
     * @see     <http://pngquant.org/>
     */
    class PngQuant
    {
        /**
         * _img
         * 
         * @var    string
         * @access protected
         */
        protected $_img;

        /**
         * __construct
         * 
         * @access public
         * @return void
         */
        public function __construct($img)
        {
            $this->_img = $img;
        }

        /**
         * compress
         * 
         * @access public
         * @return string
         */
        public function compress()
        {
            $rand = rand(1000000, 2000000);
            $original = __DIR__ . '/image.' . ($rand);
            $compressed = ($original) . '.compressed';
            file_put_contents($original, $this->_img);
            exec(
                'cd ' . __DIR__ . ' && ./pngquant --ext .compressed ' .
                    ($original),
                $output
            );

            // Contents and cleanup
            $contents = file_get_contents($compressed);
            unlink($original);
            unlink($compressed);
            return $contents;
        }
    }
