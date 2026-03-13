<?php

namespace App\Entity;

use App\Repository\TagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TagRepository::class)]
class Tag
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column(length: 20)]
    private ?string $txtColor = null;

    #[ORM\Column(length: 20)]
    private ?string $bgColor = null;

    /**
     * @var Collection<int, Task>
     */
    #[ORM\ManyToMany(targetEntity: Task::class, mappedBy: 'tags')]
    private Collection $tasks;

    /**
     * @var Collection<int, TaskTag>
     */
    #[ORM\OneToMany(targetEntity: TaskTag::class, mappedBy: 'tag', orphanRemoval: true)]
    private Collection $taskTags;

    public function __construct()
    {
        $this->tasks = new ArrayCollection();
        $this->taskTags = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getTxtColor(): ?string
    {
        return $this->txtColor;
    }

    public function setTxtColor(string $txtColor): static
    {
        $this->txtColor = $txtColor;

        return $this;
    }

    public function getBgColor(): ?string
    {
        return $this->bgColor;
    }

    public function setBgColor(string $bgColor): static
    {
        $this->bgColor = $bgColor;

        return $this;
    }

    /**
     * @return Collection<int, Task>
     */
    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    public function addTask(Task $task): static
    {
        if (!$this->tasks->contains($task)) {
            $this->tasks->add($task);
            $task->addTag($this);
        }

        return $this;
    }

    public function removeTask(Task $task): static
    {
        if ($this->tasks->removeElement($task)) {
            $task->removeTag($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, TaskTag>
     */
    public function getTaskTags(): Collection
    {
        return $this->taskTags;
    }

    public function addTaskTag(TaskTag $taskTag): static
    {
        if (!$this->taskTags->contains($taskTag)) {
            $this->taskTags->add($taskTag);
            $taskTag->setTag($this);
        }

        return $this;
    }

    public function removeTaskTag(TaskTag $taskTag): static
    {
        if ($this->taskTags->removeElement($taskTag)) {
            // set the owning side to null (unless already changed)
            if ($taskTag->getTag() === $this) {
                $taskTag->setTag(null);
            }
        }

        return $this;
    }
}
