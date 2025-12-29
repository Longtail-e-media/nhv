jQuery(function(){
    // Add class to body or specific container you want protected
    const $protected = jQuery('body').addClass('no-copy');

    // Prevent right-click context menu
    $protected.on('contextmenu', function(e){
        e.preventDefault();
        return false;
    });

    // Prevent text selection via mouse (older browsers)
    $protected.on('selectstart dragstart', function(e){
        e.preventDefault();
        return false;
    });

    // Prevent copying via keyboard shortcuts and other hotkeys
    jQuery(document).on('keydown.protectCopy', function(e){
        // list of blocked combos:
        // Ctrl/Cmd + C, X, A, S, U, P, Shift+Ctrl+I (inspect), F12 (devtools)
        const key = e.key.toLowerCase();
        const ctrl = e.ctrlKey || e.metaKey; // metaKey for mac Command
        const shift = e.shiftKey;

        // Block Ctrl/Cmd + [c,x,a,s,u,p]
        if (ctrl && ['c','x','a','s','u','p'].includes(key)) {
            e.preventDefault();
            return false;
        }

        // Block Ctrl+Shift+I (open devtools) and F12
        if ((ctrl && shift && key === 'i') || e.keyCode === 123) {
            e.preventDefault();
            return false;
        }
    });

    // Block copy event (clipboard API)
    $protected.on('copy cut', function(e){
        e.preventDefault();
        return false;
    });

    // Prevent touch selection on mobile
    $protected.on('touchstart touchmove', function(e){
        // Prevent long-press selection/menu on mobile
        // but allow normal taps by not preventDefault unless it's a long press â€” simpler approach:
        // prevent touch-and-hold selection menu:
        e.preventDefault();
    });

    // Prevent dragging images and links
    jQuery('img, a').attr('draggable', false).addClass('no-drag');

    // Optional: show a small toast/warning if user tries to right-click or copy
    // (uncomment if you want feedback)
    /*
    $protected.on('contextmenu copy', function(){
      // small visual cue
      console.log('Copying/Right-click disabled on this page.');
    });
    */

    // Helper: allow toggling protection (useful while developing)
    window.toggleCopyProtection = function(enable){
        if(enable === false){
            $protected.removeClass('no-copy');
            $protected.off('contextmenu selectstart dragstart');
            jQuery(document).off('keydown.protectCopy');
            $protected.off('copy cut touchstart touchmove');
            jQuery('img, a').attr('draggable', true).removeClass('no-drag');
        } else {
            // reload page or re-run script to re-enable; simple approach: reload
            location.reload();
        }
    };
});