mespace Lobama\BasicBundle\Security\User;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;

class FacebookUserProvider implements UserProviderInterface
{
    
    /*
    // from: https://github.com/noelg/KrissFacebookBundle/commit/c9527c7da3be08c941e40e434085b94c63607a69#diff-6
    public function __construct(\Facebook $facebook)
    {
        $this->facebook = $facebook;
    }
    */
    
    
    public function loadUserByUsername($username)
    {
        // make a call to your webservice here
        // $userData = ...
        // pretend it returns an array on success, false if there is no user
        
        // $fbUserId = 1537503248;
        $userData = 1537503248;
        
        
        die("loadUserByUsername");
        
        
        if ($userData) {
            // $password = '...';
            // ...
            echo $userData."<br>";
            return new WebserviceUser($username, $password, $salt, $roles);
        } else {
            throw new UsernameNotFoundException(sprintf('Username "%s" does not exist.', $username));
        }
    }

    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof WebserviceUser) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass($class)
    {
        return $class === 'Lobama\BasicBundle\Security\User\WebserviceUser';
    }
}
