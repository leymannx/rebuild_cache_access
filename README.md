# Rebuild Cache Access

Provides a Rebuild Cache admin toolbar button accessible to every role with the `rebuild cache access` permission set.

Everybody in need of this module read the following answer to a similar [feature request](https://www.drupal.org/node/2870483) on DO first, please.

> I kind of disagree with this because of the that shouldn't be
> necessary in the first place. With cache tags, any change that an
> editor can make should automatically invalidate all relevant caches.
> Anything else is a bug IMHO.


Nevertheless in real world sometimes it may be necessary to have other roles than the one with `administer site configuration` rebuild caches.
