<!DOCTYPE html>
<html lang="en-GB">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Chelsea and Joe's Wedding Gallery</title>
  <link rel="stylesheet" href="/styles/style.css">
  <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/featherlight@1.7.14/release/featherlight.min.css">
  <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/featherlight@1.7.14/release/featherlight.gallery.min.css">
  <script src="//code.jquery.com/jquery-latest.js"></script>
  <script src="//cdn.jsdelivr.net/npm/featherlight@1.7.14/release/featherlight.min.js" charset="utf-8"></script>
  <script src="//cdn.jsdelivr.net/npm/featherlight@1.7.14/release/featherlight.gallery.min.js" charset="utf-8"></script>
</head>
<body>
  <div class="gallery" data-featherlight-gallery data-featherlight-filter="a:not(.image__download-link)">
    <?php
      // Define the directory where your images are stored
      $directory = "images/";

      // Fetch all the files in the directory
      $images = glob($directory . "*.{jpg}", GLOB_BRACE);

      // Sort images alphabetically by filename
      natcasesort($images);

      // Output pagination links if there are more than one page
      $totalImages = count($images);
      $imagesPerPage = 20;
      $totalPages = ceil($totalImages / $imagesPerPage);

      // Get the current page number from the query string or default to 1
      $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;

      // Calculate the start and end index for the current page
      $startIndex = ($currentPage - 1) * $imagesPerPage;
      $endIndex = $startIndex + $imagesPerPage;

      // Extract the images for the current page
      $images = array_slice($images, $startIndex, $imagesPerPage);

      foreach($images as $image) {
        // Get the file extension and path info
        $extension = strtolower(pathinfo($image, PATHINFO_EXTENSION));
        $filename = pathinfo($image, PATHINFO_FILENAME);
        $directory = pathinfo($image, PATHINFO_DIRNAME);
        // The original image
        $originalSrc = "{$directory}/{$filename}.{$extension}";

        // Generate paths for new images
        $srcResized = "{$directory}/resized/{$filename}_resized.jpg";
        $srcRetina = "{$directory}/retina/{$filename}_2x.jpg";
        $webpSrcResized = "{$directory}/resized/{$filename}_resized.webp";
        $webpSrcRetina = "{$directory}/retina/{$filename}_2x.webp";

      ?>
      <div class="image">
        <a href="<?php echo $srcResized; ?>" class="image__featherlight-link">
          <picture>
              <source
                  type="image/webp"
                  srcset="/<?php echo $webpSrcResized; ?>, /<?php echo $webpSrcRetina; ?> 2x"
                  width="1920"
              >
              <source
                  type="image/jpeg"
                  srcset="/<?php echo $srcResized; ?>, /<?php echo $srcRetina; ?> 2x"
                  width="1920"
              >
              <img
                  src="/<?php echo $srcResized; ?>"
                  loading="lazy"
                  width="1920"
              >
          </picture>
        </a>
        <a class="image__download-link" href="<?php echo $originalSrc; ?>" download>Download</a>
      </div>
    <?php } ?>
  </div>
  <div class="pagination">
    <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
      <a href="?page=<?php echo $i; ?>" <?php if ($i === $currentPage) echo 'class="active"'; ?>><?php echo $i; ?></a>
    <?php } ?>
  </div>
</body>
</html>