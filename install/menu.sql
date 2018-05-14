INSERT INTO `menu` (`title_token`, `link`, `blank`, `icon`, `parent`, `groups_id`, `pos`) VALUES
-- epmloyees - group 1
('index_dashboard', '/index/index', 0, 'tachometer ', NULL, 1, 1),
('administration_title', '/administration/index', 0, 'cog', NULL, 1, 2),
('menu_basedata', NULL, 0, 'users', NULL, 1, 10),
('customers_customers', '/customers/tabledata', 0, 'users', 3, 1, 11),
('partners_title', '/partners/tabledata', 0, 'handshake-o', 3, 1, 12),
('logins_title', '/logins/tabledata', 0, 'user', 3, 1, 13),
('dnszones_title', '/dns/slidedata', 0, 'map-signs', NULL, 1, 20),
('dnsservers_title', '/dns_servers/tabledata', 0, 'circle-o', 7, 1, 23),
('jobs_title', '/jobs/index', 0, 'tasks', NULL, 1, 30),
-- partners - group 5
('index_dashboard', '/index/index', 0, 'tachometer ', NULL, 5, 1),
('partners_title', '/partners/tabledata', 0, 'handshake-o', NULL, 5, 12),
('dnszones_title', '/dns/slidedata', 0, 'map-signs', NULL, 5, 22),
('jobs_title', '/jobs/index', 0, 'tasks', NULL, 5, 30),
-- customers - group 10
('index_dashboard', '/index/index', 0, 'tachometer ', NULL, 10, 1),
('partners_title', '/partners/tabledata', 0, 'handshake-o', NULL, 10, 12),
('dnszones_title', '/dns/slidedata', 0, 'map-signs', NULL, 10, 22),
('jobs_title', '/jobs/index', 0, 'tasks', NULL, 10, 30);