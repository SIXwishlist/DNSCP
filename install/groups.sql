INSERT INTO `groups` (`id`, `name`, `permissions`) VALUES
(1, 'employees',
    'index:general:*,\r\n'
    'administration:general:*,\r\n'
    'administration:pending:*,\r\n'
    'customers:general:*,\r\n'
    'partners:general:*,\r\n'
    'partners:new:*,\r\n'
    'partners:edit:*,\r\n'
    'jobs:general:*,\r\n'
    'jobs:debug:*,\r\n'
    'dns:general:*,\r\n'
    'dns:filter_customers:*,\r\n'
    'dns:new:*,\r\n'
    'dns:edit:*,\r\n'
    'dns:edit_record:*,\r\n'
    'dns:delete:*,\r\n'
    'dns:dnssec:*,\r\n'
    'dns_servers:general:*,\r\n'
    'logins:general:*,\r\n'
    'logins:filter_customers:*'),
(5, 'partners',
    'index:general:*,\r\n'
    'partners:general:partners,\r\n'
    'dns:general:partners,\r\n'
    'dns:filter_customers:partners,\r\n'
    'dns:edit_record:partners,\r\n'
    'dns:dnssec:partners,\r\n'
    'jobs:general:partners'),
(10,'customers',
    'index:general:*,\r\n'
    'partners:general:customers,\r\n'
    'dns:general:customers,\r\n'
    'dns:edit_record:customers,\r\n'
    'dns:dnssec:customers,\r\n'   
    'jobs:general:customers');