<?php

namespace Gitonomy\Bundle\CoreBundle\Test;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\StreamOutput;
use Symfony\Bundle\FrameworkBundle\Client;

/**
 * Base class for testing the CLI tools.
 *
 * @author Alexandre Salomé <alexandre.salome@gmail.com>
 */
abstract class CommandTestCase extends WebTestCase
{
    /**
     * Runs a command and returns it output
     */
    public function runCommand(Client $client, $command)
    {
        $application = new Application($client->getKernel());
        $application->setAutoExit(false);

        $fp = tmpfile();
        $input = new StringInput($command);
        $output = new StreamOutput($fp);

        $statusCode = $application->run($input, $output);

        fseek($fp, 0);
        $result = '';
        while (!feof($fp)) {
            $result = fread($fp, 4096);
        }
        fclose($fp);

        return array($statusCode, $result);
    }
}
