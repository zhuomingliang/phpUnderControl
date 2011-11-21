<?php
/**
 * This file is part of phpUnderControl.
 *
 * PHP Version 5.2.0
 *
 * Copyright (c) 2007-2011, Manuel Pichler <mapi@phpundercontrol.org>.
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
 * @category  QualityAssurance
 * @package   VersionControl
 * @author    Sebastian Marek <proofek@gmail.com>
 * @copyright 2007-2011 Manuel Pichler. All rights reserved.
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version   SVN: $Id$
 * @link      http://www.phpundercontrol.org/
 */

/**
 * Git checkout implementation.
 *
 * @category  QualityAssurance
 * @package   VersionControl
 * @author    Sebastian Marek <proofek@gmail.com>
 * @copyright 2007-2011 Manuel Pichler. All rights reserved.
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version   Release: 0.4.0
 * @link      http://www.phpundercontrol.org/
 */
class phpucGitCheckout extends phpucAbstractCheckout
{
    private $remote = 'origin';

    private $branch = 'master';

    /**
     * Performs a git checkout.
     *
     * @return void
     * @throws phpucErrorException
     *         If the git checkout fails.
     */
    public function checkout()
    {
        $git = phpucFileUtil::findExecutable( 'git' );
        $url = escapeshellarg( $this->url );
        $cmd = "{$git} clone {$url} source";

        popen( "{$cmd} 2>&1", "r" );

        if ( !file_exists( 'source' ) )
        {
            throw new phpucErrorException( 'The project checkout has failed.' );
        }

        $cwd = getcwd();

        // Switch into checkout directory
        chdir( 'source' );

        // Add tracked remote branch
        shell_exec( "{$git} remote add {$this->remote} {$url}" );

        chdir( $cwd );
    }

    /**
     * git uses pull command to update existing repository from a remote server
     *
     * At the moment it will always pull from origin remote and master branch
     * 
     * @return string
     */
    public function getUpdateCommand()
    {
        return "pull {$this->remote} {$this->branch}";
    }
}