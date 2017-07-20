<?php

namespace Tkuska\TerytBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ZaladujMiejscowosciCommand extends ContainerAwareCommand
{
    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        parent::initialize($input, $output); //initialize parent class method

        $this->em = $this->getContainer()->get('doctrine')->getManager(); // This loads Doctrine, you can load your own services as well
    }

    /**
     * Configure the task with options and arguments.
     */
    protected function configure()
    {
        parent::configure();

        $this
                ->setName('teryt:zaladuj-miejscowosci') // this is the command you would pass to console to run the command.
                ->setDescription('Laduje miejscowosci do bazy danych')
                ->setDefinition([
                    new InputArgument('sciezka', InputArgument::REQUIRED, 'Sciezka do SIMC.csv'),
                        ]
        );
    }

    /**
     * Our console/task logic.
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $sciezka = $input->getArgument('sciezka');
        $dane = file($sciezka);
        $naglowek = str_getcsv($dane[0], ';');
        unset($dane[0]);

        foreach ($dane as $wiersz) {
            $wiersz = trim($wiersz);
            if (!$wiersz) {
                break;
            }
            $wiersz = str_getcsv($wiersz, ';');
            $wiersz = array_combine($naglowek, $wiersz);
            $class = new \Tkuska\TerytBundle\Entity\Miejscowosc();

            $class->loadDataFromArray($wiersz);
            $this->em->persist($class);
        }
        $this->em->flush();
        $this->em->flush();
    }

    /**
     * @see Command
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        if (!$input->getArgument('sciezka')) {
            $sciezka = $this->getHelper('dialog')->askAndValidate(
                    $output, 'Podaj ścieżkę do pliku XML:', function ($sciezka) {
                        if (empty($sciezka)) {
                            throw new \Exception('Nie podano ścieżki');
                        }

                        return $sciezka;
                    }
            );
            $input->setArgument('sciezka', $sciezka);
        }
    }
}
