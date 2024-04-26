<div>
    <a href="<?= $router->generate('user-add') ?>" class="btn btn-success">Ajouter</a>
    <h2>Liste des utilisateurs</h2>
    <table>
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Prénom</th>
                <th scope="col">Nom</th>
                <th scope="col">Email</th>
                <th scope="col">Role</th>
            </tr>
        </thead>
        <tbody>

          <?php foreach($users as $user) : ?>

            <tr>
                <th scope="row"><?= $user->getId() ?></th>
                <td><?= $user->getFirstName() ?></td>
                <td><?= $user->getLastName() ?></td>
                <td><?= $user->getEmail() ?></td>
                <td><span class="badge bg-danger"><?= $user->getRole() ?></span></td>
                <td>
                    <a href="<?= $router->generate('user-delete', ['id' => $user->getId()]) ?>?tokenCsrf=<?= $tokenCsrf ?>"class="btn btn-danger">supprimer</a>
                </td>
            </tr>

          <?php endforeach ?>

        </tbody>
    </table>
</div>