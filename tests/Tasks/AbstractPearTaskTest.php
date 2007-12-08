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

require_once dirname( __FILE__ ) . '/../AbstractTest.php';

/**
 * Abstract test case for pear tasks.
 * 
 * @package    phpUnderControl
 * @subpackage Tasks
 * @author     Manuel Pichler <mapi@manuel-pichler.de>
 * @copyright  2007 Manuel Pichler. All rights reserved.
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    Release: @package_version@
 * @link       http://www.phpunit.de/wiki/phpUnderControl
 */
abstract class phpucAbstractPearTaskTest extends phpucAbstractTest
{
    /**
     * The used console args object.
     *
     * @type phpucConsoleArgs
     * @var phpucConsoleArgs $args
     */
    protected $args = null;
    
    /**
     * Optional list of command line options.
     *
     * @type array<string>
     * @var array(string) $options
     */
    protected $options = array();
    
    /**
     * The test project name.
     *
     * @type string
     * @var string $projectName
     */
    protected $projectName = 'php-under-control';
    
    /**
     * The test project directory.
     *
     * @type string
     * @var string $projectDir
     */
    protected $projectDir = null;
    
    /**
     * Initializes a clean console args object and creates a project dummy.
     *
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();
        
        $this->projectDir = PHPUC_TEST_DIR . '/projects/php-under-control';
        
        $options = array(
            'example', 
            '--pear-executables-dir',
            PHPUC_TEST_DIR . '/bin',
            '--project-name',
            $this->projectName
        );
        
        foreach ( $this->options as $option )
        {
            $options[] = $option;
        }
        
        $options[] = PHPUC_TEST_DIR;
        
        $this->prepareArgv( $options );
        $this->args = new phpucConsoleArgs();
        $this->args->parse();
        
        $this->createTestDirectories(
            array(
                'projects',
                'projects/php-under-control',
            )
        );
        
        $buildFile = new phpucBuildFile( 
            $this->projectDir . '/build.xml', 
            $this->projectName
        );
        $buildFile->save();
    }
    
    /**
     * Creates a fake executable. 
     *
     * @param string $executable The executable name.
     * @param string $content    Dummy/test content for the executable.
     * 
     * @return void
     */
    protected function createExecutable( $executable, $content )
    {
        if ( !is_dir( PHPUC_TEST_DIR . '/bin' ) )
        {
            mkdir( PHPUC_TEST_DIR . '/bin' );
        }
        
        $fileName = PHPUC_TEST_DIR . '/bin/' . $executable;
        
        file_put_contents( $fileName, $content );
        chmod( $fileName, 0755 );
    }
}