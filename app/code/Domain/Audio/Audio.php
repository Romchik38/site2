<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Audio;

/** 
 * - Audio must be *activated*.
 * - Requirements to become active:
 *   - id is set
 *   - content present in the storage (loaded)
 *   - all translates
 *   - author is active
 * - Cannot be *deactivated* when:
 *   - has references from article
 */
final class Audio
{

}