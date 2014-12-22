<?php
/**
 * @package     Mautic
 * @copyright   2014 Mautic Contributors. All rights reserved.
 * @author      Mautic
 * @link        http://mautic.org
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace Mautic\UserBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use Mautic\CoreBundle\Factory\MauticFactory;
use Mautic\CoreBundle\Form\EventListener\CleanFormSubscriber;
use Mautic\CoreBundle\Form\EventListener\FormExitSubscriber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class PasswordResetType
 */
class PasswordResetType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventSubscriber(new CleanFormSubscriber());

        $builder->add('identifier', 'text', array(
            'label'      => 'mautic.user.auth.form.loginusername',
            'label_attr' => array('class' => 'sr-only'),
            'attr'       => array(
                'class'    => 'form-control',
                'preaddon'    => 'fa fa-user',
                'placeholder' => 'mautic.user.auth.form.loginusername'
            ),
            'constraints' => array(
                new Assert\NotBlank(array('message' => 'mautic.user.user.passwordreset.notblank'))
            )
        ));

        $builder->add('submit', 'submit', array(
            'attr'     => array(
                'class'   => 'btn btn-lg btn-primary btn-block',
            ),
            'label'    => 'mautic.user.user.passwordreset.reset'
        ));

        if (!empty($options["action"])) {
            $builder->setAction($options["action"]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return "passwordreset";
    }
}