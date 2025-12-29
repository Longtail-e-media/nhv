-- 2025-12-29 [SMS]
INSERT INTO `tbl_modules` (`id`, `parent_id`, `name`, `link`, `mode`, `icon_link`, `status`, `sortorder`, `added_date`, `properties`)
VALUES (NULL, '0', 'FAQ', 'faq/list', 'faq', 'icon-list', '1', '7', '2025-12-29', '');

CREATE TABLE `tbl_faq` (
`id` int(11) NOT NULL,
`title` varchar(255) NOT NULL,
`title_gr` varchar(255) NOT NULL,
`content` text NOT NULL,
`content_gr` text NOT NULL,
`status` int(11) NOT NULL,
`sortorder` int(11) NOT NULL,
`added_date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
ALTER TABLE `tbl_faq` ADD PRIMARY KEY (`id`);
ALTER TABLE `tbl_faq` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

