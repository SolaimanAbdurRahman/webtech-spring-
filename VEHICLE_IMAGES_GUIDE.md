# Vehicle Images Guide

## How to Add Images to Vehicles

### Method 1: Using External Image URLs (Recommended for Testing)

**Pros:** Quick setup, no file uploads needed
**Cons:** Depends on external services

1. **Find a car image URL** from:
   - [Unsplash](https://unsplash.com/s/photos/car) - Free high-quality photos
   - [Pexels](https://www.pexels.com/search/car/) - Free stock photos
   - [Pixabay](https://pixabay.com/images/search/car/) - Free images
   - Your own hosted images

2. **Update the database directly:**
   ```sql
   UPDATE vehicles 
   SET image_url = 'https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?w=400&h=300&fit=crop' 
   WHERE vehicle_id = 1;
   ```

3. **Or use PHP to update:**
   ```php
   $sql = "UPDATE vehicles SET image_url = :image_url WHERE vehicle_id = :vehicle_id";
   $stmt = $db->prepare($sql);
   $stmt->execute([
       ':image_url' => 'https://your-image-url.com/car.jpg',
       ':vehicle_id' => 1
   ]);
   ```

### Method 2: Local File Uploads (Recommended for Production)

**Pros:** Full control, no external dependencies
**Cons:** Requires file management

1. **Create upload directory:**
   ```bash
   mkdir -p uploads/vehicles
   chmod 755 uploads/vehicles
   ```

2. **Create upload form** (add to admin panel):
   ```html
   <form action="upload_vehicle_image.php" method="POST" enctype="multipart/form-data">
       <select name="vehicle_id">
           <option value="">Select Vehicle</option>
           <!-- Populate with vehicles -->
       </select>
       <input type="file" name="vehicle_image" accept="image/*" required>
       <button type="submit">Upload Image</button>
   </form>
   ```

3. **Create upload handler** (`upload_vehicle_image.php`):
   ```php
   <?php
   require_once 'config/database.php';
   
   if ($_SERVER['REQUEST_METHOD'] === 'POST') {
       $vehicle_id = $_POST['vehicle_id'];
       $upload_dir = 'uploads/vehicles/';
       
       if (isset($_FILES['vehicle_image'])) {
           $file = $_FILES['vehicle_image'];
           $filename = 'vehicle_' . $vehicle_id . '_' . time() . '.jpg';
           $filepath = $upload_dir . $filename;
           
           if (move_uploaded_file($file['tmp_name'], $filepath)) {
               // Update database
               $database = new Database();
               $db = $database->getConnection();
               
               $sql = "UPDATE vehicles SET image_url = :image_url WHERE vehicle_id = :vehicle_id";
               $stmt = $db->prepare($sql);
               $stmt->execute([
                   ':image_url' => $filepath,
                   ':vehicle_id' => $vehicle_id
               ]);
               
               echo "Image uploaded successfully!";
           }
       }
   }
   ?>
   ```

### Method 3: Using the Vehicle Images Table (Advanced)

The system also supports multiple images per vehicle using the `vehicle_images` table:

```sql
-- Add multiple images for a vehicle
INSERT INTO vehicle_images (vehicle_id, image_path, image_type, is_primary) VALUES
(1, 'https://example.com/car1_main.jpg', 'main', TRUE),
(1, 'https://example.com/car1_interior.jpg', 'interior', FALSE),
(1, 'https://example.com/car1_exterior.jpg', 'exterior', FALSE);
```

### Method 4: Quick Image Update Script

Create a script to quickly update vehicle images:

```php
<?php
// quick_update_images.php
require_once 'config/database.php';

$database = new Database();
$db = $database->getConnection();

$vehicle_images = [
    1 => 'https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?w=400&h=300&fit=crop',
    2 => 'https://images.unsplash.com/photo-1552519507-da3b142c6e3d?w=400&h=300&fit=crop',
    3 => 'https://images.unsplash.com/photo-1555215695-3004980ad54e?w=400&h=300&fit=crop',
    // Add more vehicles...
];

foreach ($vehicle_images as $vehicle_id => $image_url) {
    $sql = "UPDATE vehicles SET image_url = :image_url WHERE vehicle_id = :vehicle_id";
    $stmt = $db->prepare($sql);
    $stmt->execute([
        ':image_url' => $image_url,
        ':vehicle_id' => $vehicle_id
    ]);
    echo "Updated vehicle $vehicle_id with image\n";
}
?>
```

## Image Requirements

### Recommended Specifications:
- **Format:** JPG, PNG, WebP
- **Size:** 400x300 pixels (minimum)
- **File size:** Under 500KB
- **Aspect ratio:** 4:3 or 16:9

### Image Optimization:
```php
// Resize and optimize uploaded images
function optimizeImage($source_path, $destination_path, $width = 400, $height = 300) {
    $image_info = getimagesize($source_path);
    $image_type = $image_info[2];
    
    switch ($image_type) {
        case IMAGETYPE_JPEG:
            $image = imagecreatefromjpeg($source_path);
            break;
        case IMAGETYPE_PNG:
            $image = imagecreatefrompng($source_path);
            break;
        default:
            return false;
    }
    
    $resized = imagecreatetruecolor($width, $height);
    imagecopyresampled($resized, $image, 0, 0, 0, 0, $width, $height, imagesx($image), imagesy($image));
    
    imagejpeg($resized, $destination_path, 85);
    imagedestroy($image);
    imagedestroy($resized);
    
    return true;
}
```

## Testing Your Images

1. **Visit the vehicles page:** `index.php?action=vehicles`
2. **Check if images display correctly**
3. **Verify responsive behavior** on different screen sizes
4. **Test image loading speed**

## Troubleshooting

### Common Issues:

1. **Images not displaying:**
   - Check if the URL is accessible
   - Verify the image_url field in the database
   - Check browser console for errors

2. **Permission errors (local uploads):**
   - Ensure upload directory has write permissions
   - Check PHP file upload settings in php.ini

3. **Large file uploads:**
   - Increase `upload_max_filesize` in php.ini
   - Increase `post_max_size` in php.ini

### Database Commands:

```sql
-- Check current vehicle images
SELECT vehicle_id, make, model, image_url FROM vehicles;

-- Update a specific vehicle's image
UPDATE vehicles SET image_url = 'new_image_url' WHERE vehicle_id = 1;

-- Remove image from a vehicle
UPDATE vehicles SET image_url = NULL WHERE vehicle_id = 1;
```

## Best Practices

1. **Use consistent image sizes** for better layout
2. **Optimize images** for web (compress, resize)
3. **Provide alt text** for accessibility
4. **Use CDN** for better performance in production
5. **Backup original images** before processing
6. **Validate file types** before upload
7. **Handle missing images** gracefully with placeholders

## Sample Image URLs for Testing

```php
$sample_images = [
    'Toyota Corolla' => 'https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?w=400&h=300&fit=crop',
    'Honda CR-V' => 'https://images.unsplash.com/photo-1552519507-da3b142c6e3d?w=400&h=300&fit=crop',
    'BMW 5 Series' => 'https://images.unsplash.com/photo-1555215695-3004980ad54e?w=400&h=300&fit=crop',
    'Ford Focus' => 'https://images.unsplash.com/photo-1541899481282-d53bffe3c35d?w=400&h=300&fit=crop',
    'Toyota Camry' => 'https://images.unsplash.com/photo-1621007947382-bb3c3994e3fb?w=400&h=300&fit=crop',
    'Chevrolet Impala' => 'https://images.unsplash.com/photo-1544636331-e26879cd4d9b?w=400&h=300&fit=crop'
];
``` 