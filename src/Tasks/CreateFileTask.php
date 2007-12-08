<?php
/**
 * This file is part of phpUnderControl.
 *
 * Copyright (c) 2007, Manuel Pichler <mapi@manuel-pichler.de>.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *   * Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 *
 *   * Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in
 *     the documentation and/or other materials provided with the
 *     distribution.
 *
 *   * Neither the name of Manuel Pichler nor the names of his
 *     contributors may be used to endorse or promote products derived
 *     from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @package    phpUnderControl
 * @subpackage Tasks
 * @author     Manuel Pichler <mapi@manuel-pichler.de>
 * @copyright  2007 Manuel Pichler. All rights reserved.
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    SVN: $Id$
 * @link       http://www.phpunit.de/wiki/phpUnderControl
 */

/**
 * Creates a set of new files.
 *
 * @package    phpUnderControl
 * @subpackage Tasks
 * @author     Manuel Pichler <mapi@manuel-pichler.de>
 * @copyright  2007 Manuel Pichler. All rights reserved.
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    Release: @package_version@
 * @link       http://www.phpunit.de/wiki/phpUnderControl
 */
class phpucCreateFileTask extends phpucAbstractTask
{
    /**
     * List of new files.
     *
     * @type array<string>
     * @var array(string) $files
     */
    protected $files = array();
    
    /**
     * The ctor takes the console arguments and a list of files as arguments.
     *
     * @param phpucConsoleArgs $args  The console arguments.
     * @param array            $files List of files.
     */
    public function __construct( phpucConsoleArgs $args, array $files )
    {
        parent::__construct( $args );
        
        $this->files = $files;
    }
    
    /**
     * Copies all files from the <b>$files</b> properties into the cc webapps
     * folder.
     *
     * @return void
     * @throws phpucExecuteException If the execution fails.
     */
    public function execute()
    {
        echo 'Performing create file task.' . PHP_EOL;
        
        $installDir = sprintf(
            '%s/webapps/cruisecontrol', 
            $this->args->getArgument( 'cc-install-dir' ) 
        );
        
        foreach ( $this->files as $index => $file )
        {
            $filepath = $installDir . $file;

            printf( 
                '  % 2d. Creating file "%s".%s',
                ( $index + 1 ), 
                $file, 
                PHP_EOL 
            );
            
            file_put_contents( 
                $filepath,
                file_get_contents( PHPUC_DATA_DIR . '/data/' . $file )
            );
        }
        
        echo PHP_EOL;
    }
}