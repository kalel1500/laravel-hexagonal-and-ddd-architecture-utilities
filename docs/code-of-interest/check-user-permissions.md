
# Formatear los logs como JSON
```php

    public function __construct(
        private UserRepositoryContract $repositoryUser,
    )
    {
    }

    public function test(): void
    {
//        dd(userEntity()->can('see_post_detail'));

        $user1 = $this->repositoryUser->find(1);
        $user2 = $this->repositoryUser->find(2);
        $user3 = $this->repositoryUser->find(3);
        $user4 = $this->repositoryUser->find(4);
//        dump($user->toArray());
        dd($user1, $user1->toArray());

        $user1_can_see_post_detail = $user1->can('see_post_detail');
        $user1_can_filter_posts    = $user1->can('filter_posts');
        $user1_can_see_tags        = $user1->can('see_tags');
        $user1_can_admin_tags      = $user1->can('admin_tags');

        $user2_can_see_post_detail = $user2->can('see_post_detail');
        $user2_can_filter_posts    = $user2->can('filter_posts');
        $user2_can_see_tags        = $user2->can('see_tags');
        $user2_can_admin_tags      = $user2->can('admin_tags');

        $user3_can_see_post_detail = $user3->can('see_post_detail');
        $user3_can_filter_posts    = $user3->can('filter_posts');
        $user3_can_see_tags        = $user3->can('see_tags');
        $user3_can_admin_tags      = $user3->can('admin_tags');

        $user4_can_see_post_detail = $user4->can('see_post_detail');
        $user4_can_filter_posts    = $user4->can('filter_posts');
        $user4_can_see_tags        = $user4->can('see_tags');
        $user4_can_admin_tags      = $user4->can('admin_tags');

        dump([
            'user1_can_see_post_detail' => $user1_can_see_post_detail,
            'user1_can_filter_posts'    => $user1_can_filter_posts,
            'user1_can_see_tags'        => $user1_can_see_tags,
            'user1_can_admin_tags'      => $user1_can_admin_tags,
            'user2_can_see_post_detail' => $user2_can_see_post_detail,
            'user2_can_filter_posts'    => $user2_can_filter_posts,
            'user2_can_see_tags'        => $user2_can_see_tags,
            'user2_can_admin_tags'      => $user2_can_admin_tags,
            'user3_can_see_post_detail' => $user3_can_see_post_detail,
            'user3_can_filter_posts'    => $user3_can_filter_posts,
            'user3_can_see_tags'        => $user3_can_see_tags,
            'user3_can_admin_tags'      => $user3_can_admin_tags,
            'user4_can_see_post_detail' => $user4_can_see_post_detail,
            'user4_can_filter_posts'    => $user4_can_filter_posts,
            'user4_can_see_tags'        => $user4_can_see_tags,
            'user4_can_admin_tags'      => $user4_can_admin_tags,
        ]);

        $user4_can_admin_tags      = $user4->can('edit_cplan', $ystemIds, $centerIds);
        dd('fin');
    }
    
    
    public function examplePermissions()
    {
        // ONE
        // userEntity()->can('edit_roles');
        // userEntity()->is('admin');

        // ARRAY
        $array_userCan_seePostDetail_or_AdminTags = userEntity()?->can(['see_post_detail', 'admin_tags']);
        $array_userIs_admin_or_reader             = userEntity()?->is(['admin', 'reader']);

        // PIPE
        $pipe_userCan_seePostDetail_or_AdminTags = userEntity()?->can('see_post_detail|admin_tags');
        $pipe_userIs_admin_or_reader             = userEntity()?->is('admin|reader');

        dump([
            'user'                                     => userEntity()?->toArray(),
            'array_userCan_seePostDetail_or_AdminTags' => $array_userCan_seePostDetail_or_AdminTags,
            'array_userIs_admin_or_reader'             => $array_userIs_admin_or_reader,

            'pipe_userCan_seePostDetail_or_AdminTags' => $pipe_userCan_seePostDetail_or_AdminTags,
            'pipe_userIs_admin_or_reader'             => $pipe_userIs_admin_or_reader,
        ]);

        dd('fin');
    }

```