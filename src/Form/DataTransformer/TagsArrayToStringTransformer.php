<?php


namespace App\Form\DataTransformer;


use App\Entity\Tag;
use App\Repository\TagRepository;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class TagsArrayToStringTransformer implements DataTransformerInterface
{
    private $tagRepository;

    public function __construct(TagRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    /**
     * On passe d'un tag[] à une chaine
     */

    public function transform($tags):string
    {
      dump($tags);
      return implode(',',$tags);
    }
    /**
     * On passe d'une chaine à tag[]
     */

    public function reverseTransform($string):array
    {
        $names = array_filter(array_unique(array_map('trim', explode(',',$string))));
        $tags = $this->tagRepository->findBy(['name'=> $names]);
        $newNames = array_diff($names,$tags);



        foreach ($newNames as $name){
            $tag = new Tag();
            $tag->setName($name);
            $tags[]= $tag;
        }

        dump($string);
        return $tags;
    }
}