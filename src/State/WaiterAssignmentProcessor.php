<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use App\Entity\Order; // Assurez-vous d'utiliser la bonne classe pour votre entité de commande
use App\Entity\User;
use Symfony\Bundle\SecurityBundle\Security;

class WaiterAssignmentProcessor implements ProcessorInterface
{
    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')]
        private ProcessorInterface $persistProcessor,
        private Security $security
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        if (!$data instanceof Order) {
            return $this->persistProcessor->process($data, $operation, $uriVariables, $context);
        }

        $user = $this->security->getUser();

        if ($user instanceof User && in_array('ROLE_WAITER', $user->getRoles())) {
            $data->setWaiter($user);
        }

        return $this->persistProcessor->process($data, $operation, $uriVariables, $context);
    }
}