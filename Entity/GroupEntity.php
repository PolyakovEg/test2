<?php

namespace app\Entity;

use app\Dto\GroupDto;
use app\Dto\StudentDto;
use app\Repository\GroupEntityRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\SequenceGenerator;
use Doctrine\ORM\Mapping\Table;
use Exception;

#[Entity (repositoryClass: GroupEntityRepository::class)]
#[Table(name: 'GROUPS')]
class GroupEntity
{
    #[Id]
    #[Column(name: 'ID', type: Types::INTEGER)]
    #[GeneratedValue(strategy: 'SEQUENCE')]
    #[SequenceGenerator(sequenceName: "KP2411_21.GROUPPKSEQUENCE")]
    private int $id;

    #[Column(name: 'NAME', type: Types::STRING)]
    private string $name;

    #[Column(name: 'STUDY_START_DATE', type: Types::DATE_MUTABLE)]
    private DateTime $studyStartDate;

    #[Column(name: 'SPECIALIZATION_ID', type: Types::INTEGER)]
    private int $specializationId;

    #[Column(name: 'FORM_OF_EDUCATION', type: Types::STRING)]
    private string $formOfEducation;

    /** @var Collection<int, StudentEntity> An ArrayCollection of StudentEntity objects. */
    #[OneToMany(targetEntity: StudentEntity::class, mappedBy: 'group')]
    private Collection $students;

    public function __construct()
    {
        $this->students = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getStudyStartDate(): DateTime
    {
        return $this->studyStartDate;
    }

    public function setStudyStartDate(DateTime $studyStartDate): void
    {
        $this->studyStartDate = $studyStartDate;
    }

    public function getSpecializationId(): int
    {
        return $this->specializationId;
    }

    public function setSpecializationId(int $specializationId): void
    {
        $this->specializationId = $specializationId;
    }

    public function getFormOfEducation(): string
    {
        return $this->formOfEducation;
    }

    public function setFormOfEducation(string $formOfEducation): void
    {
        $this->formOfEducation = $formOfEducation;
    }

    public function getStudents(): Collection
    {
        return $this->students;
    }

    public function setStudents(Collection $students): GroupEntity
    {
        $this->students = $students;
        return $this;
    }

    /**
     * Возвращает массив студентов в алфавитном порядке.
     *
     * @return array
     */
    public function getStudentsArray(): array
    {
        $result = [];

        foreach ($this->getStudents() as $student) {
            $result[] = StudentDto::formFromEntity($student);
        }

        usort($result, function ($student1, $student2) {
            /** @var $student1 StudentDto */
            /** @var $student2 StudentDto */

            $cmpByLastName = strcmp($student1->lastName, $student2->lastName);

            return $cmpByLastName == 0 ? strcmp($student1->firstName, $student2->firstName) : $cmpByLastName;
        });

        return $result;
    }

    /**
     * Обновляет сущность с помощью DTO.
     *
     * @param GroupDto $dto
     * @return void
     * @throws Exception
     */
    public function updateFromDto(GroupDto $dto): void
    {
        $this->setName($dto->name);
        $this->setFormOfEducation($dto->formOfEducation);
        $this->setSpecializationId($dto->specializationId);
        $this->setStudyStartDate($dto->studyStartDate ? new DateTime($dto->studyStartDate) : null);
    }
}