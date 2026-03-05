<?php

namespace app\Entity;

use app\Dto\StudentDto;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\SequenceGenerator;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name: 'STUDENTS')]
class StudentEntity
{
    #[Id]
    #[Column(name: 'ID', type: Types::INTEGER)]
    #[GeneratedValue(strategy: 'SEQUENCE')]
    #[SequenceGenerator(sequenceName: "KC2203_25.PKSEQUENCE")]
    private int $id;

    #[Column(name: 'FIRST_NAME', type: Types::STRING)]
    private string $firstName;

    #[Column(name: 'LAST_NAME', type: Types::STRING)]
    private string $lastName;

    #[Column(name: 'PATRONYMIC', type: Types::STRING, nullable: true)]
    private string|null $patronymic;

    #[Column(name: 'EMAIL', type: Types::STRING, nullable: true)]
    private string|null $email;

    #[Column(name: 'IS_LIVE_IN_DORMITORY', type: Types::BOOLEAN)]
    private bool $isLiveInDormitory;

    #[Column(name: 'GROUP_ID', type: Types::INTEGER)]
    #[ManyToOne(targetEntity: GroupEntity::class, inversedBy: 'students')]
    private int $groupId;

    public function getId(): int
    {
        return $this->id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): StudentEntity
    {
        $this->firstName = formatProperNoun($firstName);
        return $this;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): StudentEntity
    {
        $this->lastName = formatProperNoun($lastName);
        return $this;
    }

    public function getPatronymic(): ?string
    {
        return $this->patronymic;
    }

    public function setPatronymic(?string $patronymic): StudentEntity
    {
        $this->patronymic = formatProperNoun($patronymic);
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): StudentEntity
    {
        $this->email = $email;
        return $this;
    }

    public function getIsLiveInDormitory(): bool
    {
        return $this->isLiveInDormitory;
    }

    public function setIsLiveInDormitory(bool $isLiveInDormitory): StudentEntity
    {
        $this->isLiveInDormitory = $isLiveInDormitory;
        return $this;
    }

    public function getGroupId(): int
    {
        return $this->groupId;
    }

    public function setGroupId(int $groupId): StudentEntity
    {
        $this->groupId = $groupId;
        return $this;
    }

    /**
     * Обновляет сущность с помощью DTO.
     *
     * @param StudentDto $dto
     * @return void
     */
    public function updateFromDto(StudentDto $dto): void
    {
        $this->setFirstName($dto->firstName);
        $this->setLastName($dto->lastName);
        $this->setPatronymic($dto->patronymic);
        $this->setEmail($dto->email);
        $this->setGroupId($dto->groupId);
        $this->setIsLiveInDormitory($dto->isLiveInDormitory);
    }
}