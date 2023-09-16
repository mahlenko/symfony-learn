<?php

namespace App\Tests\Functional\Users\Infrastructure\Repository;

use App\Tests\Resource\Fixture\UserFixture;
use App\Users\Domain\Entity\User;
use App\Users\Domain\Factory\UserFactory;
use App\Users\Domain\Repository\UserRepositoryInterface;
use App\Users\Infrastructure\Repository\UserRepository;
use Faker\Factory;
use Faker\Generator;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserRepositoryTest extends WebTestCase
{
    private UserRepositoryInterface $repository;
    private Generator $faker;
    private AbstractDatabaseTool $databaseTool;

    /**
     * @throws \Exception
     */
    public function setUp(): void {
        parent::setUp();

        $this->databaseTool = static::getContainer()->get(DatabaseToolCollection::class)->get();
        $this->repository = static::getContainer()->get(UserRepository::class);
        $this->faker = Factory::create();
    }

    /**
     * Создание пользователя
     * @return void
     */
    public function test_user_added_successful(): void {
        $email = $this->faker->email();
        $password = $this->faker->password();
        $user = (new UserFactory())->create($email, $password);

        // act
        $this->repository->add($user);

        // assert
        $existingUser = $this->repository->findByUlid($user->getUlid());
        $this->assertEquals($user->getUlid(), $existingUser->getUlid());
    }

    public function test_user_found_successful() {
        // arrange
        $executor = $this->databaseTool->loadFixtures([UserFixture::class]);
        $user = $executor->getReferenceRepository()
            ->getReference(UserFixture::REFERENCE, User::class);

        // act
        $existingUser = $this->repository->findByUlid($user->getUlid());

        // assert
        $this->assertEquals($user->getUlid(), $existingUser->getUlid());
    }
}
