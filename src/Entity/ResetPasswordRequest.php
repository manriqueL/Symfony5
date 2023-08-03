<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * ResetPasswordRequest
 *
 * @ORM\Table(name="reset_password_request", indexes={@ORM\Index(name="IDX_7CE748AA76ED395", columns={"user_id"})})
 * @ORM\Entity
 */
class ResetPasswordRequest
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="selector", type="string", length=20, nullable=false)
     */
    private $selector;

    /**
     * @var string
     *
     * @ORM\Column(name="hashed_token", type="string", length=100, nullable=false)
     */
    private $hashedToken;

    /**
     * @var datetime_immutable
     *
     * @ORM\Column(name="requested_at", type="datetime_immutable", nullable=false)
     */
    private $requestedAt;

    /**
     * @var datetime_immutable
     *
     * @ORM\Column(name="expires_at", type="datetime_immutable", nullable=false)
     */
    private $expiresAt;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;


}
