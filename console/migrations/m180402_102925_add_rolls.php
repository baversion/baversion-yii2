<?php

use yii\db\Migration;

/**
 * Class m180402_102925_add_rolls
 */
class m180402_102925_add_rolls extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        // Ban users don\'t have any permission
        $ban = $auth->createRole('ban');
        $ban->description = 'Banned user.';
        $auth->add($ban);

        // Rules and permissions of any member
        $member = $auth->createRole('member');
        $member->description = 'Registered user. Permissions are AccessPanel, Bookmark, Like, Revision, LeaveComment, EditComment.';
        $auth->add($member);

        $accessPanel = $auth->createPermission('accessPanel');
        $accessPanel->description = 'Have access to panel.';
        $auth->add($accessPanel);
        $auth->addChild($member, $accessPanel);

        $bookmark = $auth->createPermission('bookmark');
        $bookmark->description = 'Bookmark favorite contents include article, docs, course, community post, job, glossary, open source project, etc. Bookmark a post to find it faster in future. It is personal feature.';
        $auth->add($bookmark);
        $auth->addChild($member, $bookmark);

        $like = $auth->createPermission('like');
        $like->description = 'Like posts.';
        $auth->add($like);
        $auth->addChild($member, $like);

        $revision = $auth->createPermission('Revision');
        $revision->description = 'help improve post include typo, add extra information, etc.';
        $auth->add($revision);
        $auth->addChild($member, $revision);

        $leaveComment = $auth->createPermission('leaveComment');
        $leaveComment->description = 'Leave comment on posts.';
        $auth->add($leaveComment);
        $auth->addChild($member, $leaveComment);

        $editComment = $auth->createPermission('editComment');
        $editComment->description = 'Edit his comment.';
        $auth->add($editComment);
        $auth->addChild($member, $editComment);

        $takeCourse = $auth->createPermission('takeCourse');
        $takeCourse->description = 'take free course and buy course. Accessing premium contents need vip role.';
        $auth->add($takeCourse);
        $auth->addChild($member, $takeCourse);

        $createIssue = $auth->createPermission('createIssue');
        $createIssue->description = 'User with this permission can create issue.';
        $auth->add($createIssue);
        $auth->addChild($member, $createIssue);

        // Rules and permissions of vip
        $vip = $auth->createRole('vip');
        $vip->description = 'The user who pays for access to premium features.';
        $auth->add($vip);

        $accessPremium = $auth->createPermission('accessPremiumContent');
        $accessPremium->description = 'Accessing to premium features.';
        $auth->add($accessPremium);
        $auth->addChild($vip, $accessPremium);


        // Author
        $author = $auth->createRole('author');
        $author->description = 'The user who is a team member.';
        $auth->add($author);

        $createContent = $auth->createPermission('createContent');
        $createContent->description = 'Create and write in contents.';
        $auth->add($createContent);
        $auth->addChild($author, $createContent);

        // Editor
        $editor = $auth->createRole('editor');
        $editor->description = 'Editors Manage post (Create, Edit, Publish, Delete:Trash). This role is a helping role to decrease publishing time. An editor can create and approve tags.';
        $auth->add($editor);
        $auth->addChild($editor, $author);

        $managePost = $auth->createPermission('ManagePost');
        $managePost->description = 'Edit, publish or reject pending posts, include article, tags, course, ....';
        $auth->add($managePost);
        $auth->addChild($editor, $managePost);

        $manageComment = $auth->createPermission('manageComment');
        $manageComment->description = 'Manage comment of post. User with this can delete spam.';
        $auth->add($manageComment);
        $auth->addChild($editor, $manageComment);

        $manageRevision = $auth->createPermission('manageRevision');
        $manageRevision->description = 'An user with this permission can approve revision or decline them.';
        $auth->add($manageRevision);
        $auth->addChild($editor, $manageRevision);

        $manageIssue = $auth->createPermission('manageIssue');
        $manageIssue->description = 'An user with this permission can close and reopen issue topics.';
        $auth->add($manageIssue);
        $auth->addChild($editor, $manageIssue);

        // Moderator
        $moderator = $auth->createRole('moderator');
        $moderator->description = 'Moderators have access to Admin Panel and they can promote other users except admin and moderator.';
        $auth->add($moderator);
        $auth->addChild($moderator, $editor);

        $accessAdmin = $auth->createPermission('accessAdmin');
        $accessAdmin->description = 'Access admin panel.';
        $auth->add($accessAdmin);
        $auth->addChild($moderator, $accessAdmin);

        $promoteUser = $auth->createPermission('promoteUser');
        $promoteUser->description = 'Changes user role except admin and moderators. The user with this permission can\'t promote someone to moderator and admin role and he can\'t promote moderators and admins.';
        $auth->add($promoteUser);
        $auth->addChild($moderator, $promoteUser);

        $changePoint = $auth->createPermission('changePoint');
        $changePoint->description = 'Changes gained point of user except admin.';
        $auth->add($changePoint);
        $auth->addChild($moderator, $changePoint);

        // Admin
        $admin = $auth->createRole('admin');
        $admin->description = 'Admin has full access to everything. Admin manage logs. change settings and hard delete everything.';
        $auth->add($admin);
        $auth->addChild($admin, $moderator);

        $manageLog = $auth->createPermission('manageLog');
        $manageLog->description = 'See logs and delete selected or all logs if needed to improve database performance. The deleted log will save in a log file.';
        $auth->add($manageLog);
        $auth->addChild($admin, $manageLog);

        $deleteContent = $auth->createPermission('deleteContent');
        $deleteContent->description = 'Delete everything. hard delete.';
        $auth->add($deleteContent);
        $auth->addChild($admin, $deleteContent);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180402_102925_add_rolls cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180402_102925_add_rolls cannot be reverted.\n";

        return false;
    }
    */
}
