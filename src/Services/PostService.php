<?php

namespace App\Services;

use App\DTO\CreateUpdatePostPayload;
use App\Entity\Post;
use App\Entity\User;
use App\Utilities\Utility;
use Carbon\Carbon;
use Doctrine\ORM\EntityManagerInterface;
use ParagonIE\Paseto\Exception\PasetoException;
use Symfony\Component\HttpFoundation\Request;

class PostService
{

    private Post $post;

    public function __construct(public EntityManagerInterface $manager)
    {

    }

    /**
     * @throws PasetoException
     */
    public function create(Request $request, CreateUpdatePostPayload $payload): void
    {
        $this->post = new Post();
        $this->post->setTitle($payload->title);
        $this->post->setContent($payload->content);
        $this->post->setCreatedAt(Carbon::now());
        $user = $this->manager->getRepository(User::class)->find(Utility::getUserId($request));
        $user->addPost($this->post);
        $this->manager->persist($user);
        $this->manager->flush();
    }

    public function getPostAsArray(): array
    {
        return $this->post->toArray();
    }

    public function update(Post $post, CreateUpdatePostPayload $payload): void
    {
        $this->post = $post;
        $this->post->setTitle($payload->title);
        $this->post->setContent($payload->content);
    }

    public function delete(Post $post): void
    {
        $this->manager->remove($post);
        $this->manager->flush();
    }

}