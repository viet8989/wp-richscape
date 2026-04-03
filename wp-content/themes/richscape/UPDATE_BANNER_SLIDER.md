### Done. Here's what was added to functions.php:      
                                                                                          
  ## Admin Menu: "Banner Slider" (with image icon, position 25 in the sidebar)
                                              
  ## The admin page allows you to:               
    - Select images from the WordPress Media Library via the "Chọn ảnh" button                                                                                                                                                                                   
  - Add slides with the "+ Thêm slide" button                                                                                                                                                                                                                  
  - Remove slides with the ✕ button                                                                                                                                                                                                                            
  - Drag to reorder slides by the grip handle (uses jQuery UI Sortable, which is bundled with WP admin)                                                                                                                                                        
  - Set alt text for each slide for accessibility                                                                                                                                                                                                              
  - Save — stores slides to the richscape_banner_slides option, which richscape_get_banner_slides() already reads as its second fallback (after ACF)
                                                                                                                                                                                                                                                               
### After saving, the front-page banner slider will immediately use the new images.