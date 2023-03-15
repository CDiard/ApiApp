<?php

namespace App\Command;

use App\Entity\Comic;
use App\Entity\Event;
use App\Entity\Marvel;
use App\Entity\Serie;
use App\Entity\Storie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[AsCommand(
    name: 'app:import:data',
    description: 'Importer les éléments Marvel',
)]
class ImportDataCommand extends Command
{
    private EntityManagerInterface $em;
    private HttpClientInterface $client;

    public function __construct(EntityManagerInterface $entityManager, HttpClientInterface $client)
    {
        $this->em = $entityManager;
        $this->client = $client;

        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $limit = 100;
        $offset = 100;

        $this->recursiveImport($output ,'http://gateway.marvel.com/v1/public/characters?limit='.$limit.'&offset='.$offset.'&apikey=b72ca0427db6579856d797c45485130a&ts=2022-12-02%2011:00:00&hash=68faafc6e98c97646de8123a45ee106d');

        $output->writeln('Success !');

        return Command::SUCCESS;
    }

    protected function recursiveImport(OutputInterface $output, $url)
    {
        $response = $this->client->request('GET', $url);

        $json = json_decode($response->getContent(), true);

        foreach ($json['data']['results'] as $marvel) {
            $output->writeln($marvel['name'].' a été importé !');

            foreach ($marvel['comics']['items'] as $comic) {
                $ifComic = $this->em->getRepository(Comic::Class)->findBy(['name' => $comic['name']]);

                if (empty($ifComic)) {
                    $comicEntity = new Comic();
                    $comicEntity->setName($comic['name']);
                    $comicEntity->setResourceURI($comic['resourceURI']);

                    $this->em->persist($comicEntity);
                    $this->em->flush();
                }
            }

            foreach ($marvel['series']['items'] as $serie) {
                $ifSerie = $this->em->getRepository(Serie::Class)->findBy(['name' => $serie['name']]);

                if (empty($ifSerie)) {
                    $serieEntity = new Serie();
                    $serieEntity->setName($serie['name']);
                    $serieEntity->setResourceURI($serie['resourceURI']);

                    $this->em->persist($serieEntity);
                    $this->em->flush();
                }
            }

            foreach ($marvel['stories']['items'] as $storie) {
                $ifStorie = $this->em->getRepository(Storie::Class)->findBy(['name' => $storie['name']]);

                if (empty($ifStorie)) {
                    $storieEntity = new Storie();
                    $storieEntity->setName($storie['name']);
                    $storieEntity->setResourceURI($storie['resourceURI']);
                    $storieEntity->setType($storie['type']);

                    $this->em->persist($storieEntity);
                    $this->em->flush();
                }
            }

            foreach ($marvel['events']['items'] as $event) {
                $ifEvent = $this->em->getRepository(Event::Class)->findBy(['name' => $event['name']]);

                if (empty($ifEvent)) {
                    $eventEntity = new Event();
                    $eventEntity->setName($event['name']);
                    $eventEntity->setResourceURI($event['resourceURI']);

                    $this->em->persist($eventEntity);
                    $this->em->flush();
                }
            }


            $ifMarvel = $this->em->getRepository(Marvel::Class)->findBy(['name' => $marvel['name']]);

            if (empty($ifMarvel)) {
                $marvelEntity = new Marvel();
                $marvelEntity->setName($marvel['name']);
                if ($marvel['description'] != "") {
                    $marvelEntity->setDescription($marvel['description']);
                }
                $dateModified = new \DateTime($marvel['modified']);
                $marvelEntity->setModified($dateModified);
                $marvelEntity->setThumbnail($marvel['thumbnail']['path'].'.'.$marvel['thumbnail']['extension']);
                $marvelEntity->setResourceURI($marvel['resourceURI']);

                foreach ($marvel['comics']['items'] as $comic) {
                    if ($comic['name'] != "") {
                        $comicMarvel = $this->em->getRepository(Comic::Class)->findOneBy(['name' => $comic['name']]);
                        $marvelEntity->addComic($comicMarvel);
                    }
                }

                foreach ($marvel['series']['items'] as $serie) {
                    if ($serie['name'] != "") {
                        $serieMarvel = $this->em->getRepository(Serie::Class)->findOneBy(['name' => $serie['name']]);
                        $marvelEntity->addSeries($serieMarvel);
                    }
                }

                foreach ($marvel['stories']['items'] as $storie) {
                    if ($storie['name'] != "") {
                        $storieMarvel = $this->em->getRepository(Storie::Class)->findOneBy(['name' => $storie['name']]);
                        $marvelEntity->addStory($storieMarvel);
                    }
                }

                foreach ($marvel['events']['items'] as $event) {
                    if ($event['name'] != "") {
                        $eventMarvel = $this->em->getRepository(Event::Class)->findOneBy(['name' => $event['name']]);
                        $marvelEntity->addEvent($eventMarvel);
                    }
                }

                $this->em->persist($marvelEntity);
                $this->em->flush();
            }
        }
    }
}
