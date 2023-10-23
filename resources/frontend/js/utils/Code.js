export const CreateCodeUsageBoilerplate = (collection) => {
    return `<?php
    use Sapphire\\Collection\\Collection;
    use Sapphire\\Collection\\CollectionEntry;

    $collection = Collection::GetByName("${collection.info.id}");
    $data = $collection->contents; `
}

// $data = $collection->Where(
//         fn (CollectionEntry $entry) => $entry->info->id > 100 && $entry->info->id < 1000
//     );