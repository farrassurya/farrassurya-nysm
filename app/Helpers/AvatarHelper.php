<?php

if (!function_exists('generateAvatar')) {
    /**
     * Generate avatar dengan initial nama user
     */
    function generateAvatar($name, $size = 100) {
        // Ambil huruf pertama dari setiap kata
        $words = explode(' ', trim($name));
        $initials = '';

        foreach($words as $word) {
            if (!empty($word)) {
                $initials .= strtoupper(substr($word, 0, 1));
            }
            // Maksimal 2 huruf
            if (strlen($initials) >= 2) break;
        }

        // Jika cuma 1 kata, ambil 2 huruf pertama
        if (strlen($initials) == 1 && strlen($words[0]) > 1) {
            $initials .= strtoupper(substr($words[0], 1, 1));
        }

        // Array warna background yang bagus
        $colors = [
            '#FF6B6B', '#4ECDC4', '#45B7D1', '#96CEB4', '#FECA57',
            '#FF9FF3', '#54A0FF', '#5F27CD', '#00D2D3', '#FF9F43',
            '#EE5A24', '#0984E3', '#A29BFE', '#6C5CE7', '#FD79A8',
            '#E17055', '#00B894', '#00CEC9', '#6C5CE7', '#A29BFE'
        ];

        // Pilih warna berdasarkan hash nama (supaya konsisten)
        $colorIndex = abs(crc32($name)) % count($colors);
        $bgColor = $colors[$colorIndex];

        // Generate SVG avatar
        $svg = '<svg width="' . $size . '" height="' . $size . '" xmlns="http://www.w3.org/2000/svg">';
        $svg .= '<circle cx="' . ($size/2) . '" cy="' . ($size/2) . '" r="' . ($size/2) . '" fill="' . $bgColor . '"/>';
        $svg .= '<text x="50%" y="50%" text-anchor="middle" dy="0.35em" fill="white" font-family="Arial, sans-serif" font-size="' . ($size * 0.4) . '" font-weight="bold">';
        $svg .= $initials;
        $svg .= '</text>';
        $svg .= '</svg>';

        // Convert ke base64 untuk bisa langsung dipake di img src
        return 'data:image/svg+xml;base64,' . base64_encode($svg);
    }
}

if (!function_exists('getProfileImage')) {
    /**
     * Get profile image atau generate avatar jika tidak ada foto
     */
    function getProfileImage($user, $size = 100) {
        if (!empty($user->profile_picture)) {
            return asset('storage/' . $user->profile_picture);
        }

        return generateAvatar($user->name ?? 'User', $size);
    }
}
