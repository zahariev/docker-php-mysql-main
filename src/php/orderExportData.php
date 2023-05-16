<?


function orderExportData($startDate, $endDate) 
{

    $conn = require_once 'connection.php';

    // Prepare the SQL query
    $sql = "SELECT
    o.id AS 'Номер на поръчка',
    o.name AS 'Малко име',
    o.family AS 'Фамилия',
    o.phone AS 'Телефон',
    o.email AS 'И-мейл',
    o.comment AS 'Коментар към поръчка',
    o.updated_at AS 'Дата на поръчка',
    o.delivery_type AS 'Начин на доставка',
    CASE
        WHEN o.delivery_type LIKE 'До адрес%' THEN CONCAT(o.city, ' ', o.address)
        WHEN o.delivery_type LIKE 'Офис на%' THEN CONCAT('Oфис no. ', o.office)
        ELSE ''
    END AS 'Адрес на доставка',
    o.status AS 'Статус на поръчка',
    o.payment_type AS 'Начин на плащане',
    o.invoice_type AS 'Тип на фактурата',
    CASE
        WHEN o.invoice_type = 'Юридическо лице' THEN o.invoice_j_firm
        ELSE ''
    END AS 'Име на фирма',
    CASE
        WHEN o.invoice_type = 'Юридическо лице' THEN o.invoice_j_mol
        ELSE ''
    END AS 'МОЛ на фирма',
    CASE
        WHEN o.invoice_type = 'Юридическо лице' THEN o.invoice_j_address
        ELSE ''
    END AS 'Седалище на фирма',
    CASE
        WHEN o.invoice_type = 'Юридическо лице' THEN o.invoice_j_eik
        ELSE ''
    END AS 'ЕИК на фирма',
    CASE
        WHEN o.invoice_type = 'Юридическо лице' THEN o.invoice_j_has_vat
        ELSE ''
    END AS ' ДДС',
    CASE
        WHEN o.invoice_type = 'Физическо лице' THEN o.invoice_p_name
        ELSE ''
    END AS 'Име за фактура',
    CASE
        WHEN o.invoice_type = 'Физическо лице' THEN o.invoice_p_family
        ELSE ''
    END AS 'Фамилия за фактура',
    CASE
        WHEN o.invoice_type = 'Физическо лице' THEN o.invoice_p_address
        ELSE ''
    END AS 'Адрес за фактура',
    CASE
        WHEN o.invoice_type = 'Физическо лице' THEN o.invoice_p_egn
        ELSE ''
    END AS 'ЕГН за фактура'
   
FROM orders o
WHERE DATE_FORMAT(o.updated_at,'%Y-%m-%d') BETWEEN DATE_FORMAT( ? ,'%Y-%m-%d') AND DATE_FORMAT(?,'%Y-%m-%d') 
ORDER BY o.id ASC";

    // Prepare the statement
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
    die("Error in preparing the SQL query: " . $conn->error);
}

    // Bind the parameters
    $stmt->bind_param('ss', $startDate, $endDate);

    // Execute the query
    $stmt->execute();

    // Get the result set
    $result = $stmt->get_result();
    return $result;//->fetch_all(MYSQLI_ASSOC);
}

?>