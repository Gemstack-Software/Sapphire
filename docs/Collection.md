# Collection

Collection is group of data containing few things:
+ Information about collection identification
+ Collection data schema
+ Collection data entries

1. Information about collection identification
Collection contains data about it's:

+ uuid (auto-generated by Sapphire while creating collection)
+ id (first name of collection)
+ display_name (name of collection that can be displayed)
+ single_name (name of collection in singular form)

2. Collection data schema
Collection contains it's schema - the blueprint of entries. It's like a class that contains information about something and can be cloned (like: new class {})
Collection schema should should be updated only in empty collection to prevent data crashes.

Schema contains few boolean options (Sometimes it's also named "allowed properties"):
+ id (Should sapphire auto-increment id for every collection entry)
+ uuid (Should sapphire generates random uuid for every collection entry)
+ name (Should sapphire store name for ...)
+ created_at (Should sapphire store when ... was created)
+ created_by (Should sapphire store by who ... was created)
+ updated_at (Should sapphire store when ... was updated)
+ updated_by (Should sapphire store by who ... was updated)

Also the schema contains the "class body" or properties - The Schema Items.
For example - Collection "Animals" has:
+ ShortText name - The schema item to contain animal name
+ ShortText type - The schema item to contain animal type (species)
+ Date birthday - ...

etc