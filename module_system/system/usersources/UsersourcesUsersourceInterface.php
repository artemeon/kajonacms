<?php
/*"******************************************************************************************************
*   (c) 2004-2006 by MulchProductions, www.mulchprod.de                                                 *
*   (c) 2007-2016 by Kajona, www.kajona.de                                                              *
*       Published under the GNU LGPL v2.1, see /system/licence_lgpl.txt                                 *
*-------------------------------------------------------------------------------------------------------*
*	$Id$                                            *
********************************************************************************************************/

namespace Kajona\System\System\Usersources;

/**
 * Interface defining all main methods for a single usersource.
 *
 * @author sidler@mulchprod.de
 * @since 3.4.1
 * @package module_usersource
 */
interface UsersourcesUsersourceInterface
{

    /**
     * Tries to authenticate a user with the given credentials.
     * The password is unencrypted, each source should take care of its own encryption.
     *
     * @param UsersourcesUserInterface $objUser
     * @param string $strPassword
     *
     * @return bool
     */
    public function authenticateUser(UsersourcesUserInterface $objUser, $strPassword);

    /**
     * Indicates if the creation of goups is supported by this source
     *
     * @return bool
     */
    public function getCreationOfGroupsAllowed();

    /**
     * Indicates if the creation of users is supported by this source
     *
     * @return bool
     */
    public function getCreationOfUsersAllowed();


    /**
     * Defines if the group-memberships are editable via the system or not
     *
     * @return bool
     */
    public function getMembersEditable();

    /**
     * Loads the group identified by the passed id
     *
     * @param string $strId
     *
     * @return UsersourcesGroupInterface or null
     */
    public function getGroupById($strId);

    /**
     * Returns an empty group, e.g. to fetch the fields available and
     * in order to fill a new one.
     *
     * @return UsersourcesGroupInterface
     */
    public function getNewGroup();

    /**
     * Returns an empty user, e.g. to fetch the fields available and
     * in order to fill a new one.
     *
     * @return UsersourcesUserInterface
     */
    public function getNewUser();

    /**
     * Loads the user identified by the passed id
     *
     * @param string $strId
     *
     * @param bool $bitIgnoreDeletedFlag
     * @return UsersourcesUserInterface or null
     */
    public function getUserById($strId, $bitIgnoreDeletedFlag = false);

    /**
     * Loads the user identified by the passed name.
     * This method may be called during the authentication of users and may be used as a hook
     * in order to create new users in the central database not yet existing.
     *
     * @param string $strUsername this could be the username entered by the user on the ui
     *
     * @return UsersourcesUserInterface or null
     */
    public function getUserByUsername($strUsername);

    /**
     * Searches for a user within the subsystems' database, may not be necessarily already contained
     * within the subsystems mirror
     *
     * @param $strUsername
     * @return UsersourcesUserInterface[]
     */
    public function searchUser($strUsername, $intMax = 10);

    /**
     * Returns an array of group-ids provided by the current source.
     * return string
     * @param bool $bitIgnoreSystemGroups
     * @return
     */
    public function getAllGroupIds($bitIgnoreSystemGroups = false);

    /**
     * Returns a readable name of the source, e.g. "Kajona" or "LDAP Company 1"
     *
     * @return mixed
     */
    public function getStrReadableName();
}
