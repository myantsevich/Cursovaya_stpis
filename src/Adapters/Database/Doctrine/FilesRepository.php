<?php

namespace BelkinDom\Adapters\Database\Doctrine;

use BelkinDom\Store\File\File;
use BelkinDom\Store\File\Files;
use Doctrine\Common\Persistence\ObjectManager;

final class FilesRepository implements Files
{
    /**
     * @var ObjectManager
     */
    private $objectManager;

    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * @param File $file
     */
    public function save(File $file)
    {
        $this->objectManager->persist($file);
        $this->objectManager->flush();
    }

    /**
     * @param File $file
     */
    public function update(File $file)
    {
        $this->objectManager->merge($file);
        $this->objectManager->flush();
    }

    /**
     * @param File $file
     */
    public function remove(File $file)
    {
        $this->objectManager->remove($file);
        $this->objectManager->flush();
    }
}
