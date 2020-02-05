<?php


namespace App\Form\Type;


use App\Form\DataTransformer\TagsArrayToStringTransformer;
use App\Repository\TagRepository;
use Symfony\Bridge\Doctrine\Form\DataTransformer\CollectionToArrayTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TagsInputType extends AbstractType
{
    private $tagRepository;

    public function __construct(TagRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       $builder
           ->addModelTransformer(new CollectionToArrayTransformer(), true)
           ->addModelTransformer(
               new TagsArrayToStringTransformer($this->tagRepository),true
           );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'attr'=> [
                'data-role' => 'tagsinput',
            ]
        ]);
    }

    public function getParent(){
        return TextType::class;
    }

}