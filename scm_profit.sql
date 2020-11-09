-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 09, 2020 at 07:58 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `scm_profit`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_app_receipt`
--

CREATE TABLE `tb_app_receipt` (
  `code` varchar(25) NOT NULL,
  `doc_date` date NOT NULL,
  `due_date` date NOT NULL,
  `inv_year` varchar(4) NOT NULL,
  `company_code` varchar(5) NOT NULL,
  `office_code` varchar(10) NOT NULL,
  `debtor_code` varchar(15) NOT NULL,
  `terms` int(3) NOT NULL,
  `contact_person` varchar(50) NOT NULL,
  `sender_name` varchar(50) NOT NULL,
  `sender_date` date NOT NULL,
  `receiver_name` varchar(50) NOT NULL,
  `receiver_date` date NOT NULL,
  `remarks` varchar(150) NOT NULL,
  `status` varchar(10) NOT NULL,
  `created` datetime NOT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `modified` datetime NOT NULL,
  `modified_by` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_app_receipt`
--

INSERT INTO `tb_app_receipt` (`code`, `doc_date`, `due_date`, `inv_year`, `company_code`, `office_code`, `debtor_code`, `terms`, `contact_person`, `sender_name`, `sender_date`, `receiver_name`, `receiver_date`, `remarks`, `status`, `created`, `created_by`, `modified`, `modified_by`) VALUES
('SYIT-200000002', '2020-11-06', '2020-12-06', '2020', 'IBTO', 'SYIT', '0960000040', 30, 'COBA AJA', 'Messenger', '2020-11-09', 'PIC Debtor', '2020-11-10', 'TEST JA', 'Completed', '2020-11-04 17:28:14', NULL, '2020-11-04 17:29:05', '');

-- --------------------------------------------------------

--
-- Table structure for table `tb_app_receipt_items`
--

CREATE TABLE `tb_app_receipt_items` (
  `id` varchar(15) NOT NULL,
  `detail_id` varchar(15) NOT NULL,
  `code` varchar(20) NOT NULL,
  `inv_no` varchar(30) NOT NULL,
  `inv_date` date NOT NULL,
  `currency` varchar(5) NOT NULL,
  `amount` decimal(18,2) NOT NULL,
  `tax_amount` decimal(15,2) NOT NULL,
  `sap_reference` varchar(15) NOT NULL,
  `booking_code` varchar(30) NOT NULL,
  `job_number` varchar(30) NOT NULL,
  `job_ref` varchar(50) NOT NULL,
  `remarks` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_app_receipt_items`
--

INSERT INTO `tb_app_receipt_items` (`id`, `detail_id`, `code`, `inv_no`, `inv_date`, `currency`, `amount`, `tax_amount`, `sap_reference`, `booking_code`, `job_number`, `job_ref`, `remarks`) VALUES
('5fa2823eebb00', '5f9fcd8018f5b', 'SYIT-200000002', 'IBJKT-IN-2071241', '2020-07-24', 'IDR', '575000.00', '57500.00', '9300000086', 'IBJKT-BKG-2044105', 'IBJKT-RE-2000420', 'Rem 1678', ''),
('5fa2823eebb08', '5f9fcd9d2abaf', 'SYIT-200000002', 'IBJKT-IN-2071243', '2020-07-24', 'IDR', '575000.00', '57500.00', '9300000087', 'IBJKT-BKG-2044105', 'IBJKT-RE-2000420', 'Rem 1678', '');

-- --------------------------------------------------------

--
-- Table structure for table `tb_debtor`
--

CREATE TABLE `tb_debtor` (
  `code` varchar(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `address` varchar(150) DEFAULT NULL,
  `city` varchar(30) NOT NULL,
  `zip_code` varchar(10) NOT NULL,
  `country_code` varchar(2) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(30) NOT NULL,
  `npwp` varchar(30) NOT NULL,
  `office_code` varchar(10) NOT NULL,
  `credit_term` int(11) NOT NULL,
  `currency` varchar(5) NOT NULL,
  `contact_person` varchar(50) NOT NULL,
  `created` datetime DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_debtor`
--

INSERT INTO `tb_debtor` (`code`, `name`, `address`, `city`, `zip_code`, `country_code`, `phone`, `email`, `npwp`, `office_code`, `credit_term`, `currency`, `contact_person`, `created`, `created_by`) VALUES
('0960000004', 'Lintas Niaga Jaya, PT PT LNJ', 'Jl. Ende No. 21 Tanjung Priok', 'JAKARTA', '99999', 'ID', '-', '-', '-', 'SYIB', 30, 'IDR', '-', '2020-11-05 20:14:47', 'bp_postcus'),
('0960000040', 'EVONIK SUMI ASIH, PT ', 'JL. CEMPAKA KM.38 JATIMULYA, TAMBUN', 'JAWA BARAT', '17510', 'ID', '-', '-', '-', 'SYIB', 30, 'IDR', '-', '2020-11-05 20:35:41', 'bp_postcus'),
('0960000043', 'Airlangga Hartarto', '18A Medan Merdeka Barat', 'Jakarta Pusat', '12001', 'ID', '-', '-', '-', 'SYIB', 30, 'IDR', '-', '2020-11-05 19:16:54', 'bp_postcus');

-- --------------------------------------------------------

--
-- Table structure for table `tb_interfaces`
--

CREATE TABLE `tb_interfaces` (
  `id` varchar(15) NOT NULL,
  `code` varchar(20) NOT NULL,
  `proTime` datetime DEFAULT NULL,
  `interfaces` varchar(50) DEFAULT NULL,
  `directions` varchar(50) DEFAULT NULL,
  `descriptions` text DEFAULT NULL,
  `messages` text DEFAULT NULL,
  `frontend_text` text NOT NULL,
  `backend_text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_interfaces`
--

INSERT INTO `tb_interfaces` (`id`, `code`, `proTime`, `interfaces`, `directions`, `descriptions`, `messages`, `frontend_text`, `backend_text`) VALUES
('5f927b2355d22', 'IBJKT-IN-2071249', '2020-11-02 16:23:58', 'receivable', 'SAP_FIPOST', 'IBJKT-IN-2071249', '[\"Error in document: BKPFF 0000 S4DCLNT320\",\"Customer 960000040 is not defined in company code IRBO\",\"Customer 960000040 is not defined in company code IRBO\"]', '{\"Header\":{\"MessageType\":\"AR\",\"MessageVersion\":\"1\",\"MessageIdentifier\":\"db0780d8-dc9c-4cae-ac9e-3ac2ab1b1e8b\",\"SentDatetime\":\"2020-07-24T11:54:07.1727216Z\",\"SentDatetimeZone\":\"(UTC+07:00) Bangkok, Hanoi, Jakarta\",\"Partners\":{\"PartnerInformation\":{\"ContactInformation\":[]}}},\"Invoices\":{\"InvoiceInfo\":{\"ActionCode\":\"1\",\"Office\":\"CKIB\",\"OperationOffice\":\"IBJKT\",\"InvoiceNo\":\"IBJKT-IN-2071249\",\"InvoiceDate\":\"20200724\",\"InvoiceDueDate\":\"20200807\",\"CreatedBy\":\"121204772\",\"CreatedOn\":\"20200724114139\",\"ApprovedBy\":\"121204772\",\"ApprovedOn\":\"20200724115040\",\"InvoiceType\":\"Invoice\",\"ProformaInvoiceNo\":[],\"ProformaInvoiceDate\":[],\"TransactionDate\":\"20200724000000\",\"YearCode\":\"1\",\"Remarks\":\"Rem 1678\",\"PaymentTerms\":\"14\",\"VoucherNo\":[],\"SpInvoiceRequire\":\"N\",\"IsOperationInvoice\":\"Y\",\"IsLineLevelGst\":\"Y\",\"AmountSummary\":{\"BillingInvoiceCurrency\":\"IDR\",\"BillingCurrencyExchangeRate\":\"1.00000000\",\"BaseCurrencyCode\":\"IDR\",\"TotalGrossAmount\":\"575000.00\",\"BaseTotalGrossAmount\":\"575000.00\",\"TotalDiscountAmount\":\"0.00\",\"BaseTotalDiscountAmount\":\"0.00\",\"TotalTaxAmount\":\"57500.00\",\"BaseTotalTaxAmount\":\"57500.00\",\"GrandInvoiceAmount\":\"632500.00\",\"BaseGrandInvoiceAmount\":\"632500.00\",\"TaxSummary\":{\"TaxInfo\":{\"Group\":\"VAT10 @ 10.0000%\",\"Code\":\"N\",\"Percentage\":\"10.00000\",\"BillingSummTaxAmount\":\"57500.00\",\"BaseSummTaxAmount\":\"57500.00\"}},\"DiscountSummary\":[],\"WithholdingTaxTdsSummary\":[]},\"Debtor\":{\"AccountType\":\"DEBTOR\",\"AccountCode\":\"960000040\",\"Code\":\"960000040\",\"Name\":\"Debtor 001\",\"Address\":\"Address\",\"CreditTerms\":\"14\"},\"Charges\":{\"ChargeInfo\":[{\"SeqNo\":\"1\",\"ChargeCode\":\"CC0019\",\"ChargeDescription\":\"BOOKING CONTAINER\",\"Quantity\":\"1.00000\",\"Uom\":\"EQUIPMENT\",\"Rate\":\"25000.00000\",\"Currency\":\"IDR\",\"ChargeAmount\":\"25000.00\",\"ChargeBillingExchangeRate\":\"1.00000000\",\"BillingAmount\":\"25000.00\",\"BillingExchangeRate\":\"1.00000000\",\"BaseAmount\":\"25000.00\",\"PostingCode\":\"4001000002\",\"ChargeTaxes\":{\"ChargeTaxInfo\":{\"TaxGroup\":\"VAT10\",\"TaxCode\":\"N\",\"TaxDescription\":\"N10\",\"TaxPercentage\":\"10.00000\",\"TaxBasedOn\":\"[Value]\",\"TaxValue\":\"10.00000\",\"TaxBillingAmount\":\"2500.00\",\"TaxBaseAmount\":\"2500.00\",\"TaxFormula\":\"[Value]\",\"TaxAccountMapped\":\"2104010001\"}},\"Job\":{\"JobInfo\":{\"JobNumber\":\"IBJKT-RE-2000420\",\"JobType\":\"ROE\",\"JobChargeCurrency\":\"IDR\",\"JobChargeAmount\":\"25000.00\",\"BookingNumber\":\"IBJKT-BKG-2044105\"}},\"References\":[]},{\"SeqNo\":\"2\",\"ChargeCode\":\"CC0002\",\"ChargeDescription\":\"STAPLE CONTAINER\",\"Quantity\":\"1.00000\",\"Uom\":\"FIXED\",\"Rate\":\"550000.00000\",\"Currency\":\"IDR\",\"ChargeAmount\":\"550000.00\",\"ChargeBillingExchangeRate\":\"1.00000000\",\"BillingAmount\":\"550000.00\",\"BillingExchangeRate\":\"1.00000000\",\"BaseAmount\":\"550000.00\",\"PostingCode\":\"4001000003\",\"ChargeTaxes\":{\"ChargeTaxInfo\":{\"TaxGroup\":\"VAT10\",\"TaxCode\":\"N\",\"TaxDescription\":\"N10\",\"TaxPercentage\":\"10.00000\",\"TaxBasedOn\":\"[Value]\",\"TaxValue\":\"10.00000\",\"TaxBillingAmount\":\"55000.00\",\"TaxBaseAmount\":\"55000.00\",\"TaxFormula\":\"[Value]\",\"TaxAccountMapped\":\"2104010001\"}},\"Job\":{\"JobInfo\":{\"JobNumber\":\"IBJKT-RE-2000420\",\"JobType\":\"ROE\",\"JobChargeCurrency\":\"IDR\",\"JobChargeAmount\":\"550000.00\",\"BookingNumber\":\"IBJKT-BKG-2044105\"}},\"References\":[]}]},\"JobSummary\":{\"JobSummaryInfo\":{\"JobNumber\":\"IBJKT-RE-2000420\",\"JobType\":\"SEA\",\"ClientCode\":\"DBT0001\",\"ClientName\":\"Debtor 001\",\"ShipperCode\":\"SHP001\",\"ShipperName\":\"Test Shipper\",\"ConsigneeCode\":\"CON001\",\"ConsigneeName\":\"Test Consignee\",\"PoNumber\":\"Rem 1678\",\"BookingNo\":\"IBJKT-BKG-2044105\",\"BookingDate\":\"20200708\",\"ShipmentOrderNo\":\"Rem 1678\",\"EtdDate\":\"20200709000000\",\"EtaDate\":\"20200709000000\",\"AtdDate\":\"20200709000000\",\"AtaDate\":\"20200709000000\",\"PortOfOriginCode\":\"IDSUB\",\"PortOfOriginName\":\"SURABAYA\",\"PortOfDestinationCode\":\"PHMNS\",\"PortOfDestinationName\":\"Manila South Harbour\",\"CountryOfOriginCode\":\"ID\",\"CountryOfOriginName\":\"Indonesia\",\"CountryOfDestinationCode\":\"PH\",\"CountryOfDestinationName\":\"Philippines\",\"PlaceOfReceiptCode\":\"POR\",\"PlaceOfReceiptName\":\"POR\",\"PlaceOfDeliveryCode\":\"POD\",\"PlaceOfDeliveryName\":\"POD\",\"Package\":\"13980\",\"PackageUom\":\"CTN\",\"VolumeUom\":\"CBM\",\"NetWeight\":\"209700.00000\",\"GrossWeight\":\"218227.80000\",\"ChWeight\":\"218227.80000\",\"WeightUom\":\"KGS\",\"MovementType\":\"DS\",\"ContainerSummary\":\"1 X DRYC - 20; \",\"ShipmentType\":\"DIRECT\",\"JobCreatedOn\":\"20200708083213\",\"JobCreatedBy\":\"060102499\",\"SalesPersonCode\":\"110403996\",\"SalesPersonName\":\"Alex\",\"Status\":\"Initiated\",\"TransportationMode\":\"Road\",\"Manifest\":{\"ManifestInfo\":[]},\"JobReferences\":{\"JobReferenceInfo\":[{\"RefFieldName\":\"Booking Ref. No\",\"RefFieldValue\":[]},{\"RefFieldName\":\"Vessel\",\"RefFieldValue\":\"Eliza V.0989-022A\"},{\"RefFieldName\":\"Business Segment\",\"RefFieldValue\":\"International\"},{\"RefFieldName\":\"ClientCode\",\"RefFieldValue\":\"DBT0001\"},{\"RefFieldName\":\"ExecutingOfficeCode\",\"RefFieldValue\":\"TST\"}]},\"OwnerOfficeCode\":\"IBJKT\",\"OwnerOfficeName\":\"IB Jakarta\",\"ExecutingOfficeCode\":\"IBJKT\",\"ExecutingOfficeName\":\"IB Jakarta\",\"BookingConfirmationDate\":\"20200708\"}},\"InvoiceReferences\":{\"InvoiceReferenceInfo\":[{\"RefFieldName\":\"Cost Tax Invoice Number\",\"RefFieldValue\":[]},{\"RefFieldName\":\"Cost Tax Invoice date\",\"RefFieldValue\":[]},{\"RefFieldName\":\"CreatedByCode\",\"RefFieldValue\":\"User\"},{\"RefFieldName\":\"SrNo\",\"RefFieldValue\":\"1\"}]}}}}', '{\"Fitrxlgc\":{\"item\":[{\"LgcBelnr\":\"1\",\"LgcBuzei\":1,\"Bldat\":\"2020-07-24\",\"Blart\":\"ZT\",\"Budat\":\"2020-07-24\",\"Monat\":\"07\",\"Waers\":\"IDR\",\"Xblnr\":\"IBJKT-IN-2071249\",\"Bktxt\":\"IBJKT-RE-2000420\",\"Bukrs\":\"IRBO\",\"Hkont\":\"4001000002\",\"Wrbtr\":250,\"Valut\":\"2020-07-24\",\"Prctr\":null,\"Kostl\":\"\",\"Zuonr\":\"IBJKT-IN-2071249\",\"Sgtxt\":\"Detail Teks\",\"Shkzg\":\"H\",\"Lifnr\":\"\",\"Kunnr\":\"\",\"RefLgcBelnr\":\"\",\"FiBelnr\":\"\",\"FiGjahr\":\"\",\"Umskz\":\"\",\"RefKey1\":\"50\"},{\"LgcBelnr\":\"1\",\"LgcBuzei\":2,\"Bldat\":\"2020-07-24\",\"Blart\":\"ZT\",\"Budat\":\"2020-07-24\",\"Monat\":\"07\",\"Waers\":\"IDR\",\"Xblnr\":\"IBJKT-IN-2071249\",\"Bktxt\":\"IBJKT-RE-2000420\",\"Bukrs\":\"IRBO\",\"Hkont\":\"4001000003\",\"Wrbtr\":5500,\"Valut\":\"2020-07-24\",\"Prctr\":null,\"Kostl\":\"\",\"Zuonr\":\"IBJKT-IN-2071249\",\"Sgtxt\":\"Detail Teks\",\"Shkzg\":\"H\",\"Lifnr\":\"\",\"Kunnr\":\"\",\"RefLgcBelnr\":\"\",\"FiBelnr\":\"\",\"FiGjahr\":\"\",\"Umskz\":\"\",\"RefKey1\":\"50\"},{\"LgcBelnr\":\"1\",\"LgcBuzei\":3,\"Bldat\":\"2020-07-24\",\"Blart\":\"ZT\",\"Budat\":\"2020-07-24\",\"Monat\":\"07\",\"Waers\":\"IDR\",\"Xblnr\":\"IBJKT-IN-2071249\",\"Bktxt\":\"IBJKT-RE-2000420\",\"Bukrs\":\"IRBO\",\"Hkont\":\"2104010001\",\"Wrbtr\":25,\"Valut\":\"2020-07-24\",\"Prctr\":\"\",\"Kostl\":\"\",\"Zuonr\":\"IBJKT-IN-2071249\",\"Sgtxt\":\"Vat - Out\",\"Shkzg\":\"H\",\"Lifnr\":\"\",\"Kunnr\":\"\",\"RefLgcBelnr\":\"\",\"FiBelnr\":\"\",\"FiGjahr\":\"\",\"Umskz\":\"\",\"RefKey1\":\"50\"},{\"LgcBelnr\":\"1\",\"LgcBuzei\":4,\"Bldat\":\"2020-07-24\",\"Blart\":\"ZT\",\"Budat\":\"2020-07-24\",\"Monat\":\"07\",\"Waers\":\"IDR\",\"Xblnr\":\"IBJKT-IN-2071249\",\"Bktxt\":\"IBJKT-RE-2000420\",\"Bukrs\":\"IRBO\",\"Hkont\":\"2104010001\",\"Wrbtr\":550,\"Valut\":\"2020-07-24\",\"Prctr\":\"\",\"Kostl\":\"\",\"Zuonr\":\"IBJKT-IN-2071249\",\"Sgtxt\":\"Vat - Out\",\"Shkzg\":\"H\",\"Lifnr\":\"\",\"Kunnr\":\"\",\"RefLgcBelnr\":\"\",\"FiBelnr\":\"\",\"FiGjahr\":\"\",\"Umskz\":\"\",\"RefKey1\":\"50\"},{\"LgcBelnr\":\"1\",\"LgcBuzei\":5,\"Bldat\":\"2020-07-24\",\"Blart\":\"ZT\",\"Budat\":\"2020-07-24\",\"Monat\":\"07\",\"Waers\":\"IDR\",\"Xblnr\":\"IBJKT-IN-2071249\",\"Bktxt\":\"IBJKT-RE-2000420\",\"Bukrs\":\"IRBO\",\"Hkont\":\"960000040\",\"Wrbtr\":6325,\"Valut\":\"2020-07-24\",\"Prctr\":\"\",\"Kostl\":\"\",\"Zuonr\":\"IBJKT-IN-2071249\",\"Sgtxt\":\"Tex_Head\",\"Shkzg\":\"S\",\"Lifnr\":\"\",\"Kunnr\":\"960000040\",\"RefLgcBelnr\":\"\",\"FiBelnr\":\"\",\"FiGjahr\":\"\",\"Umskz\":\"\",\"RefKey1\":\"01\"}]},\"Return\":{\"item\":[{\"Type\":\"\",\"Id\":\"\",\"Number\":\"\",\"Message\":\"\",\"LogNo\":\"\",\"LogMsgNo\":\"\",\"MessageV1\":\"\",\"MessageV2\":\"\",\"MessageV3\":\"\",\"MessageV4\":\"\",\"Parameter\":\"\",\"Row\":\"\",\"Field\":\"\",\"System\":\"\"},{\"Type\":\"\",\"Id\":\"\",\"Number\":\"\",\"Message\":\"\",\"LogNo\":\"\",\"LogMsgNo\":\"\",\"MessageV1\":\"\",\"MessageV2\":\"\",\"MessageV3\":\"\",\"MessageV4\":\"\",\"Parameter\":\"\",\"Row\":\"\",\"Field\":\"\",\"System\":\"\"},{\"Type\":\"\",\"Id\":\"\",\"Number\":\"\",\"Message\":\"\",\"LogNo\":\"\",\"LogMsgNo\":\"\",\"MessageV1\":\"\",\"MessageV2\":\"\",\"MessageV3\":\"\",\"MessageV4\":\"\",\"Parameter\":\"\",\"Row\":\"\",\"Field\":\"\",\"System\":\"\"},{\"Type\":\"\",\"Id\":\"\",\"Number\":\"\",\"Message\":\"\",\"LogNo\":\"\",\"LogMsgNo\":\"\",\"MessageV1\":\"\",\"MessageV2\":\"\",\"MessageV3\":\"\",\"MessageV4\":\"\",\"Parameter\":\"\",\"Row\":\"\",\"Field\":\"\",\"System\":\"\"},{\"Type\":\"\",\"Id\":\"\",\"Number\":\"\",\"Message\":\"\",\"LogNo\":\"\",\"LogMsgNo\":\"\",\"MessageV1\":\"\",\"MessageV2\":\"\",\"MessageV3\":\"\",\"MessageV4\":\"\",\"Parameter\":\"\",\"Row\":\"\",\"Field\":\"\",\"System\":\"\"}]},\"Test\":\"\"}'),
('5f9fc42d11115', 'SUIT-SET-2000018', '2020-11-08 11:09:27', 'settlement', 'SAP_FIPOST', 'SUIT-SET-2000018', 'wsdl error: Getting http://PBBs4hdap00.ic4sap.bluebirdgroup.com:8000/sap/bc/srt/wsdl/flv_10002A111AD1/bndg_url/sap/bc/srt/rfc/sap/zifi_post_fitrx_rfc_2/320/zifi_post_fitrx_rfc_2/zifi_post_fitrx_rfc_2?sap-client=320 - HTTP ERROR: Couldn\'t open socket connection to server http://PBBs4hdap00.ic4sap.bluebirdgroup.com:8000/sap/bc/srt/wsdl/flv_10002A111AD1/bndg_url/sap/bc/srt/rfc/sap/zifi_post_fitrx_rfc_2/320/zifi_post_fitrx_rfc_2/zifi_post_fitrx_rfc_2?sap-client=320, Error (10060): A connection attempt failed because the connected party did not properly respond after a period of time, or established connection failed because connected host has failed to respond.\r\n', '{\"Header\":{\"MessageType\":\"Settlement\",\"MessageVersion\":\"1\",\"MessageIdentifier\":\"c679e2ce-9361-4afa-87c4-082f85ebdec0\",\"MessageDateTime\":\"20201022052004\",\"Partners\":{\"PartnerInformation\":{\"ContactInformation\":[]}}},\"SettlementDetail\":{\"Settlement\":{\"BasicDetails\":{\"SettlementNo\":\"SUIT-SET-2000018\",\"Date\":\"20201015000000\",\"BaseOffice\":{\"Code\":\"SUIT\",\"Name\":\"Iron Bird Jakarta\"},\"OfficeBaseCurrency\":\"IDR\",\"VendorDetails\":{\"Code\":\"Driver\",\"Name\":\"Driver (Own Transport)\",\"Address1\":\"-\",\"Country\":[]},\"ResourceDetails\":{\"ResourceFunction\":\"Driver\",\"Code\":\"Driver\",\"Name\":\" Driver 2  2\"},\"CreatedBy\":\"jignesh\"},\"AdvanceRequests\":{\"AdvanceRequest\":{\"BasicDetails\":{\"AdvanceNo\":\"SUIT-AR-2000016\",\"Date\":\"20201015120000\",\"BaseOffice\":{\"Code\":\"SUIT\",\"Name\":\"Iron Bird Jakarta\"},\"OfficeBaseCurrency\":\"IDR\",\"AdvanceAmount\":\"3057000.00000\",\"AdvanceCurrency\":\"IDR\",\"ExchangeRate\":\"1.00000\",\"AmountInBaseCurrency\":\"3057000.00000\",\"AmountSettled\":\"2720000.00000\",\"AssetDetails\":{\"AssetType\":[],\"AssetNo\":\"B9251UEV\"}},\"ChargeDetails\":{\"ChargeDetail\":[{\"JobNo\":\"SUIT-RL-2000038\",\"JobDate\":\"20201015041730\",\"ServiceType\":\"SEA\",\"ProcessType\":\"Local\",\"Charge\":{\"Code\":\"Kawlan\",\"AccountCode\":\"5001130020\",\"Description\":\"Kawlan\"},\"BasedOn\":\"Vehicle\",\"UOM\":[],\"Quantity\":\"1.00000\",\"Rate\":\"100000.00000\",\"Amount\":\"100000.00000\",\"VendorInvoiceNo\":\"SUIT-CINV-2000012\",\"VendorInvoiceDate\":\"20201015120000\"},{\"JobNo\":\"SUIT-RL-2000038\",\"JobDate\":\"20201015041730\",\"ServiceType\":\"SEA\",\"ProcessType\":\"Local\",\"Charge\":{\"Code\":\"DanaSolar\",\"AccountCode\":\"5001130020\",\"Description\":\"Dana Solar\"},\"BasedOn\":\"Vehicle\",\"UOM\":[],\"Quantity\":\"1.00000\",\"Rate\":\"1400000.00000\",\"Amount\":\"1400000.00000\",\"VendorInvoiceNo\":\"SUIT-CINV-2000012\",\"VendorInvoiceDate\":\"20201015120000\"},{\"JobNo\":\"SUIT-RL-2000038\",\"JobDate\":\"20201015041730\",\"ServiceType\":\"SEA\",\"ProcessType\":\"Local\",\"Charge\":{\"Code\":\"DpKomisi\",\"AccountCode\":\"5001130020\",\"Description\":\"Dp Komisi\"},\"BasedOn\":\"Vehicle\",\"UOM\":[],\"Quantity\":\"1.00000\",\"Rate\":\"500000.00000\",\"Amount\":\"500000.00000\",\"VendorInvoiceNo\":\"SUIT-CINV-2000012\",\"VendorInvoiceDate\":\"20201015120000\"},{\"JobNo\":\"SUIT-RL-2000038\",\"JobDate\":\"20201015041730\",\"ServiceType\":\"SEA\",\"ProcessType\":\"Local\",\"Charge\":{\"Code\":\"Parking\",\"AccountCode\":\"5001130020\",\"Description\":\"Parking Charges\"},\"BasedOn\":\"Vehicle\",\"UOM\":[],\"Quantity\":\"1.00000\",\"Rate\":\"150000.00000\",\"Amount\":\"150000.00000\",\"VendorInvoiceNo\":\"SUIT-CINV-2000012\",\"VendorInvoiceDate\":\"20201015120000\"},{\"JobNo\":\"SUIT-RL-2000038\",\"JobDate\":\"20201015041730\",\"ServiceType\":\"SEA\",\"ProcessType\":\"Local\",\"Charge\":{\"Code\":\"Toll\",\"AccountCode\":\"5001130020\",\"Description\":\"Toll Charges\"},\"BasedOn\":\"Vehicle\",\"UOM\":[],\"Quantity\":\"1.00000\",\"Rate\":\"495000.00000\",\"Amount\":\"495000.00000\",\"VendorInvoiceNo\":\"SUIT-CINV-2000012\",\"VendorInvoiceDate\":\"20201015120000\"},{\"JobNo\":\"SUIT-RL-2000038\",\"JobDate\":\"20201015041730\",\"ServiceType\":\"SEA\",\"ProcessType\":\"Local\",\"Charge\":{\"Code\":\"Bongkar\",\"AccountCode\":\"9001130020\",\"Description\":\"Bongkar Charges\"},\"BasedOn\":\"Vehicle\",\"UOM\":[],\"Quantity\":\"1.00000\",\"Rate\":\"75000.00000\",\"Amount\":\"75000.00000\",\"VendorInvoiceNo\":\"SUIT-CINV-2000012\",\"VendorInvoiceDate\":\"20201015120000\"}]},\"AdvancePostingDetails\":{\"AdvancePosting\":[{\"AccountPostingCode\":\"1101040001\",\"AccountType\":\"Cr\",\"AccountCurrency\":\"IDR\",\"AccountAmount\":\"337000.00000\"},{\"AccountPostingCode\":\"1101010001\",\"AccountType\":\"Dr\",\"AccountCurrency\":\"IDR\",\"AccountAmount\":\"337000.00000\"}]}}}}}}', '{\"Fitrxlgc\":{\"item\":[{\"LgcBelnr\":\"1\",\"LgcBuzei\":1,\"Bldat\":\"2020-10-15\",\"Blart\":\"ZL\",\"Budat\":\"2020-10-15\",\"Monat\":\"10\",\"Waers\":\"IDR\",\"Xblnr\":\"SUIT-SET-2000018\",\"Bktxt\":\"SUIT-AR-2000016\",\"Bukrs\":\"IBTO\",\"Hkont\":\"5001130020\",\"Wrbtr\":1000,\"Valut\":\"2020-10-15\",\"Prctr\":\"\",\"Kostl\":\"PSHIT00F05\",\"Zuonr\":\"SUIT-AR-2000016\",\"Sgtxt\":\"SUIT-RL-2000038\",\"Shkzg\":\"S\",\"Lifnr\":\"\",\"Kunnr\":\"\",\"RefLgcBelnr\":\"\",\"FiBelnr\":\"\",\"FiGjahr\":\"\",\"Umskz\":\"\",\"RefKey1\":\"40\"},{\"LgcBelnr\":\"1\",\"LgcBuzei\":2,\"Bldat\":\"2020-10-15\",\"Blart\":\"ZL\",\"Budat\":\"2020-10-15\",\"Monat\":\"10\",\"Waers\":\"IDR\",\"Xblnr\":\"SUIT-SET-2000018\",\"Bktxt\":\"SUIT-AR-2000016\",\"Bukrs\":\"IBTO\",\"Hkont\":\"5001130020\",\"Wrbtr\":14000,\"Valut\":\"2020-10-15\",\"Prctr\":\"\",\"Kostl\":\"PSHIT00F05\",\"Zuonr\":\"SUIT-AR-2000016\",\"Sgtxt\":\"SUIT-RL-2000038\",\"Shkzg\":\"S\",\"Lifnr\":\"\",\"Kunnr\":\"\",\"RefLgcBelnr\":\"\",\"FiBelnr\":\"\",\"FiGjahr\":\"\",\"Umskz\":\"\",\"RefKey1\":\"40\"},{\"LgcBelnr\":\"1\",\"LgcBuzei\":3,\"Bldat\":\"2020-10-15\",\"Blart\":\"ZL\",\"Budat\":\"2020-10-15\",\"Monat\":\"10\",\"Waers\":\"IDR\",\"Xblnr\":\"SUIT-SET-2000018\",\"Bktxt\":\"SUIT-AR-2000016\",\"Bukrs\":\"IBTO\",\"Hkont\":\"5001130020\",\"Wrbtr\":5000,\"Valut\":\"2020-10-15\",\"Prctr\":\"\",\"Kostl\":\"PSHIT00F05\",\"Zuonr\":\"SUIT-AR-2000016\",\"Sgtxt\":\"SUIT-RL-2000038\",\"Shkzg\":\"S\",\"Lifnr\":\"\",\"Kunnr\":\"\",\"RefLgcBelnr\":\"\",\"FiBelnr\":\"\",\"FiGjahr\":\"\",\"Umskz\":\"\",\"RefKey1\":\"40\"},{\"LgcBelnr\":\"1\",\"LgcBuzei\":4,\"Bldat\":\"2020-10-15\",\"Blart\":\"ZL\",\"Budat\":\"2020-10-15\",\"Monat\":\"10\",\"Waers\":\"IDR\",\"Xblnr\":\"SUIT-SET-2000018\",\"Bktxt\":\"SUIT-AR-2000016\",\"Bukrs\":\"IBTO\",\"Hkont\":\"5001130020\",\"Wrbtr\":1500,\"Valut\":\"2020-10-15\",\"Prctr\":\"\",\"Kostl\":\"PSHIT00F05\",\"Zuonr\":\"SUIT-AR-2000016\",\"Sgtxt\":\"SUIT-RL-2000038\",\"Shkzg\":\"S\",\"Lifnr\":\"\",\"Kunnr\":\"\",\"RefLgcBelnr\":\"\",\"FiBelnr\":\"\",\"FiGjahr\":\"\",\"Umskz\":\"\",\"RefKey1\":\"40\"},{\"LgcBelnr\":\"1\",\"LgcBuzei\":5,\"Bldat\":\"2020-10-15\",\"Blart\":\"ZL\",\"Budat\":\"2020-10-15\",\"Monat\":\"10\",\"Waers\":\"IDR\",\"Xblnr\":\"SUIT-SET-2000018\",\"Bktxt\":\"SUIT-AR-2000016\",\"Bukrs\":\"IBTO\",\"Hkont\":\"5001130020\",\"Wrbtr\":4950,\"Valut\":\"2020-10-15\",\"Prctr\":\"\",\"Kostl\":\"PSHIT00F05\",\"Zuonr\":\"SUIT-AR-2000016\",\"Sgtxt\":\"SUIT-RL-2000038\",\"Shkzg\":\"S\",\"Lifnr\":\"\",\"Kunnr\":\"\",\"RefLgcBelnr\":\"\",\"FiBelnr\":\"\",\"FiGjahr\":\"\",\"Umskz\":\"\",\"RefKey1\":\"40\"},{\"LgcBelnr\":\"1\",\"LgcBuzei\":6,\"Bldat\":\"2020-10-15\",\"Blart\":\"ZL\",\"Budat\":\"2020-10-15\",\"Monat\":\"10\",\"Waers\":\"IDR\",\"Xblnr\":\"SUIT-SET-2000018\",\"Bktxt\":\"SUIT-AR-2000016\",\"Bukrs\":\"IBTO\",\"Hkont\":\"8001130020\",\"Wrbtr\":750,\"Valut\":\"2020-10-15\",\"Prctr\":\"\",\"Kostl\":\"PSHIT00F05\",\"Zuonr\":\"SUIT-AR-2000016\",\"Sgtxt\":\"SUIT-RL-2000038\",\"Shkzg\":\"S\",\"Lifnr\":\"\",\"Kunnr\":\"\",\"RefLgcBelnr\":\"\",\"FiBelnr\":\"\",\"FiGjahr\":\"\",\"Umskz\":\"\",\"RefKey1\":\"40\"},{\"LgcBelnr\":\"1\",\"LgcBuzei\":7,\"Bldat\":\"2020-10-15\",\"Blart\":\"ZL\",\"Budat\":\"2020-10-15\",\"Monat\":\"10\",\"Waers\":\"IDR\",\"Xblnr\":\"SUIT-SET-2000018\",\"Bktxt\":\"SUIT-AR-2000016\",\"Bukrs\":\"IBTO\",\"Hkont\":\"1101040001\",\"Wrbtr\":27200,\"Valut\":\"2020-10-15\",\"Prctr\":\"\",\"Kostl\":\"\",\"Zuonr\":\"SUIT-AR-2000016\",\"Sgtxt\":null,\"Shkzg\":\"H\",\"Lifnr\":\"\",\"Kunnr\":\"\",\"RefLgcBelnr\":\"\",\"FiBelnr\":\"\",\"FiGjahr\":\"\",\"Umskz\":\"\",\"RefKey1\":\"50\"}]},\"Return\":{\"item\":[{\"Type\":\"\",\"Id\":\"\",\"Number\":\"\",\"Message\":\"\",\"LogNo\":\"\",\"LogMsgNo\":\"\",\"MessageV1\":\"\",\"MessageV2\":\"\",\"MessageV3\":\"\",\"MessageV4\":\"\",\"Parameter\":\"\",\"Row\":\"\",\"Field\":\"\",\"System\":\"\"},{\"Type\":\"\",\"Id\":\"\",\"Number\":\"\",\"Message\":\"\",\"LogNo\":\"\",\"LogMsgNo\":\"\",\"MessageV1\":\"\",\"MessageV2\":\"\",\"MessageV3\":\"\",\"MessageV4\":\"\",\"Parameter\":\"\",\"Row\":\"\",\"Field\":\"\",\"System\":\"\"},{\"Type\":\"\",\"Id\":\"\",\"Number\":\"\",\"Message\":\"\",\"LogNo\":\"\",\"LogMsgNo\":\"\",\"MessageV1\":\"\",\"MessageV2\":\"\",\"MessageV3\":\"\",\"MessageV4\":\"\",\"Parameter\":\"\",\"Row\":\"\",\"Field\":\"\",\"System\":\"\"},{\"Type\":\"\",\"Id\":\"\",\"Number\":\"\",\"Message\":\"\",\"LogNo\":\"\",\"LogMsgNo\":\"\",\"MessageV1\":\"\",\"MessageV2\":\"\",\"MessageV3\":\"\",\"MessageV4\":\"\",\"Parameter\":\"\",\"Row\":\"\",\"Field\":\"\",\"System\":\"\"},{\"Type\":\"\",\"Id\":\"\",\"Number\":\"\",\"Message\":\"\",\"LogNo\":\"\",\"LogMsgNo\":\"\",\"MessageV1\":\"\",\"MessageV2\":\"\",\"MessageV3\":\"\",\"MessageV4\":\"\",\"Parameter\":\"\",\"Row\":\"\",\"Field\":\"\",\"System\":\"\"},{\"Type\":\"\",\"Id\":\"\",\"Number\":\"\",\"Message\":\"\",\"LogNo\":\"\",\"LogMsgNo\":\"\",\"MessageV1\":\"\",\"MessageV2\":\"\",\"MessageV3\":\"\",\"MessageV4\":\"\",\"Parameter\":\"\",\"Row\":\"\",\"Field\":\"\",\"System\":\"\"},{\"Type\":\"\",\"Id\":\"\",\"Number\":\"\",\"Message\":\"\",\"LogNo\":\"\",\"LogMsgNo\":\"\",\"MessageV1\":\"\",\"MessageV2\":\"\",\"MessageV3\":\"\",\"MessageV4\":\"\",\"Parameter\":\"\",\"Row\":\"\",\"Field\":\"\",\"System\":\"\"}]},\"Test\":\"\"}'),
('5f9fc93d85f0f', 'IBJKT-REQ-200030', '2020-11-08 10:59:53', 'advance', 'SAP_FIPOST', 'IBJKT-REQ-200030', 'wsdl error: Getting http://PBBs4hdap00.ic4sap.bluebirdgroup.com:8000/sap/bc/srt/wsdl/flv_10002A111AD1/bndg_url/sap/bc/srt/rfc/sap/zifi_post_fitrx_rfc_2/320/zifi_post_fitrx_rfc_2/zifi_post_fitrx_rfc_2?sap-client=320 - HTTP ERROR: Couldn\'t open socket connection to server http://PBBs4hdap00.ic4sap.bluebirdgroup.com:8000/sap/bc/srt/wsdl/flv_10002A111AD1/bndg_url/sap/bc/srt/rfc/sap/zifi_post_fitrx_rfc_2/320/zifi_post_fitrx_rfc_2/zifi_post_fitrx_rfc_2?sap-client=320, Error (10060): A connection attempt failed because the connected party did not properly respond after a period of time, or established connection failed because connected host has failed to respond.\r\n', '{\"AdvanceRequestDetails\":{\"BasicDetails\":{\"AdvanceNo\":\"IBJKT-REQ-200030\",\"Date\":\"20200724120000\",\"Remark\":\"Driver Cash Uang Jalan\",\"BaseOffice\":{\"Code\":\"SUIT\",\"Name\":\"IB Jakarta\"},\"OfficeBaseCurrency\":\"IDR\",\"AdvanceAmount\":\"240000.00000\",\"AdvanceCurrency\":\"IDR\",\"ExchangeRate\":\"1.00000\",\"AmountinBaseCurrency\":\"240000\",\"VendorDetails\":{\"Code\":\"Driver\",\"Name\":\"Driver Vendor\",\"Address1\":\"Address Line 1\",\"Address2\":\"Address Line 2\",\"City\":\"Jakarta\",\"ZipCode\":[],\"State\":[],\"Country\":[]},\"ResourceDetails\":{\"ResourceFunction\":\"Driver\",\"Code\":\"Driver2\",\"Name\":\"Driver2\"},\"AssetDetails\":[],\"ServiceClassDetails\":[],\"FinalizationDate\":\"20200724093600\"},\"ChargeDetails\":{\"ChargeDetail\":[{\"ServiceType\":\"Road Local\",\"Charge\":{\"Code\":\"Toll\",\"Description\":\"Toll Charges\"},\"JobsheetChargeIdentifierID\":[],\"BasedOn\":\"Vehicle\",\"UOM\":[],\"Quantity\":\"1.00000\",\"Rate\":\"50000.00000\",\"Amount\":\"50000.00000\",\"ContractNo\":[],\"IsVariance\":\"No\"},{\"ServiceType\":\"Local\",\"Charge\":{\"Code\":\"Parking\",\"Description\":\"Parking Charges\"},\"JobsheetChargeIdentifierID\":[],\"BasedOn\":\"Vehicle\",\"UOM\":[],\"Quantity\":\"1.00000\",\"Rate\":\"70000.00000\",\"Amount\":\"70000.00000\",\"ContractNo\":[],\"IsVariance\":\"No\"},{\"ServiceType\":\"Road Local\",\"Charge\":{\"Code\":\"Fuel\",\"Description\":\"Fuel Charges\"},\"JobsheetChargeIdentifierID\":[],\"BasedOn\":\"Vehicle\",\"UOM\":[],\"Quantity\":\"1.00000\",\"Rate\":\"120000.00000\",\"Amount\":\"120000.00000\",\"ContractNo\":[],\"IsVariance\":\"No\"}]},\"AdvancePostingDetails\":{\"AdvancePosting\":[{\"AccountPostingCode\":\"1101040001\",\"AccountType\":\"Dr\",\"AccountCurrency\":\"IDR\",\"AccountAmount\":\"240000.00000\"},{\"AccountPostingCode\":\"4101010001\",\"AccountType\":\"Cr\",\"AccountCurrency\":\"IDR\",\"AccountAmount\":\"240000.00000\"}]}}}', '{\"Fitrxlgc\":{\"item\":[{\"LgcBelnr\":\"1\",\"LgcBuzei\":1,\"Bldat\":\"2020-07-24\",\"Blart\":\"ZL\",\"Budat\":\"2020-07-24\",\"Monat\":\"07\",\"Waers\":\"IDR\",\"Xblnr\":\"IBJKT-REQ-200030\",\"Bktxt\":\"Driver Cash Uang Jalan\",\"Bukrs\":\"IBTO\",\"Hkont\":\"1101040001\",\"Wrbtr\":2400,\"Valut\":\"2020-07-24\",\"Prctr\":\"\",\"Kostl\":\"\",\"Zuonr\":\"IBJKT-REQ-200030\",\"Sgtxt\":\"Driver Cash Uang Jalan\",\"Shkzg\":\"S\",\"Lifnr\":\"\",\"Kunnr\":\"\",\"RefLgcBelnr\":\"\",\"FiBelnr\":\"\",\"FiGjahr\":\"\",\"Umskz\":\"\",\"RefKey1\":40},{\"LgcBelnr\":\"1\",\"LgcBuzei\":2,\"Bldat\":\"2020-07-24\",\"Blart\":\"ZL\",\"Budat\":\"2020-07-24\",\"Monat\":\"07\",\"Waers\":\"IDR\",\"Xblnr\":\"IBJKT-REQ-200030\",\"Bktxt\":\"Driver Cash Uang Jalan\",\"Bukrs\":\"IBTO\",\"Hkont\":\"7101010001\",\"Wrbtr\":2400,\"Valut\":\"2020-07-24\",\"Prctr\":\"\",\"Kostl\":\"\",\"Zuonr\":\"IBJKT-REQ-200030\",\"Sgtxt\":\"Driver Cash Uang Jalan\",\"Shkzg\":\"H\",\"Lifnr\":\"\",\"Kunnr\":\"\",\"RefLgcBelnr\":\"\",\"FiBelnr\":\"\",\"FiGjahr\":\"\",\"Umskz\":\"\",\"RefKey1\":50}]},\"Return\":{\"item\":[{\"Type\":\"\",\"Id\":\"\",\"Number\":\"\",\"Message\":\"\",\"LogNo\":\"\",\"LogMsgNo\":\"\",\"MessageV1\":\"\",\"MessageV2\":\"\",\"MessageV3\":\"\",\"MessageV4\":\"\",\"Parameter\":\"\",\"Row\":\"\",\"Field\":\"\",\"System\":\"\"},{\"Type\":\"\",\"Id\":\"\",\"Number\":\"\",\"Message\":\"\",\"LogNo\":\"\",\"LogMsgNo\":\"\",\"MessageV1\":\"\",\"MessageV2\":\"\",\"MessageV3\":\"\",\"MessageV4\":\"\",\"Parameter\":\"\",\"Row\":\"\",\"Field\":\"\",\"System\":\"\"}]},\"Test\":\"\"}'),
('5f9fd27acc716', 'TST-CI-2025561', '2020-11-02 16:33:46', 'payable', 'SAP_FIPOST', 'TST-CI-2025561', '[\"Error in document: BKPFF 0000 S4DCLNT320\",\"G\\/L account 9001280001 is not defined in chart of accounts IBCA\",\"G\\/L account 9001280001 is not defined in chart of accounts IBCA\",\"Account 9001280001 does not exist in chart of accounts IBCA\"]', '{\"Header\":{\"MessageType\":\"AP\",\"MessageVersion\":\"1\",\"MessageIdentifier\":\"b0bab1d8-320d-4851-a79d-148396e61308\",\"SentDatetime\":\"2020-07-24T11:51:01.5838572Z\",\"SentDatetimeZone\":\"(UTC+07:00) Bangkok, Hanoi, Jakarta\",\"Partners\":{\"PartnerInformation\":{\"ContactInformation\":[]}}},\"Invoices\":{\"InvoiceInfo\":{\"ActionCode\":\"1\",\"Office\":\"SUIT\",\"OperationOffice\":\"IBJKT\",\"InvoiceNo\":\"TST-CI-2025561\",\"InvoiceDate\":\"20200724\",\"InvoiceDueDate\":\"20200812\",\"CreatedBy\":\"User\",\"CreatedOn\":\"20200724114302\",\"ApprovedBy\":\"User\",\"ApprovedOn\":\"20200724114942\",\"PostedBy\":\"User\",\"PostedOn\":\"20200724114942\",\"InvoiceType\":\"Invoice\",\"InvoiceReferenceNo\":\"000056378\",\"InvoiceReferenceDate\":\"20200713\",\"YearCode\":\"1\",\"VoucherNo\":[],\"IsOperationInvoice\":\"Y\",\"IsLineLevelGst\":\"Y\",\"AmountSummary\":{\"BillingInvoiceCurrency\":\"IDR\",\"BillingCurrencyExchangeRate\":\"1.00000000\",\"BaseCurrencyCode\":\"IDR\",\"TotalGrossAmount\":\"444000.00\",\"BaseTotalGrossAmount\":\"444000.00\",\"TotalDiscountAmount\":\"0.00\",\"BaseTotalDiscountAmount\":\"0.00\",\"TotalTaxAmount\":\"44100.00\",\"BaseTotalTaxAmount\":\"44100.00\",\"GrandInvoiceAmount\":\"488100.00\",\"BaseGrandInvoiceAmount\":\"488100.00\",\"TaxSummary\":{\"TaxInfo\":{\"Group\":\"VAT10 @ 10.0000%\",\"Code\":\"N\",\"Percentage\":\"10.00000\",\"BillingSummTaxAmount\":\"44100.00\",\"BaseSummTaxAmount\":\"44100.00\"}},\"DiscountSummary\":[],\"WithholdingTaxTdsSummary\":[]},\"Vendor\":{\"AccountType\":\"VENDOR\",\"AccountCode\":\"2105010002\",\"Code\":\"0800000100\",\"Name\":\"AURIONPRO SOLUTIONS PT\",\"Address\":\"SURABAYA\",\"CreditTerms\":\"30\",\"References\":[]},\"Charges\":{\"ChargeInfo\":[{\"SeqNo\":\"1\",\"ChargeCode\":\"L00021\",\"ChargeDescription\":\"Lifting\",\"Quantity\":\"1.00000\",\"Uom\":\"FIXED\",\"Rate\":\"286000.00000\",\"Currency\":\"IDR\",\"ChargeAmount\":\"286000.00\",\"ChargeBillingExchangeRate\":\"1.00000000\",\"BillingAmount\":\"286000.00\",\"BillingExchangeRate\":\"1.00000000\",\"BaseAmount\":\"286000.00\",\"PostingCode\":\"9001280001\",\"ChargeTaxes\":{\"ChargeTaxInfo\":{\"TaxGroup\":\"VAT10\",\"TaxCode\":\"N\",\"TaxDescription\":\"N10\",\"TaxPercentage\":\"10.00000\",\"TaxBasedOn\":\"[Value]\",\"TaxValue\":\"10.00000\",\"TaxBillingAmount\":\"28600.00\",\"TaxBaseAmount\":\"28600.00\",\"TaxFormula\":\"[Value]\",\"TaxAccountMapped\":\"1107010003\"}},\"Job\":{\"JobInfo\":{\"JobNumber\":\"TST-RE-2000420\",\"JobType\":\"ROE\",\"JobChargeCurrency\":\"IDR\",\"JobChargeAmount\":\"286000.00\",\"BookingNumber\":\"TST-BKG-2044105\"}},\"References\":[]},{\"SeqNo\":\"2\",\"ChargeCode\":\"O00004\",\"ChargeDescription\":\"DOCK\",\"Quantity\":\"1.00000\",\"Uom\":\"FIXED\",\"Rate\":\"35000.00000\",\"Currency\":\"IDR\",\"ChargeAmount\":\"35000.00\",\"ChargeBillingExchangeRate\":\"1.00000000\",\"BillingAmount\":\"35000.00\",\"BillingExchangeRate\":\"1.00000000\",\"BaseAmount\":\"35000.00\",\"PostingCode\":\"6001280001\",\"ChargeTaxes\":{\"ChargeTaxInfo\":{\"TaxGroup\":\"VAT10\",\"TaxCode\":\"N\",\"TaxDescription\":\"N10\",\"TaxPercentage\":\"10.00000\",\"TaxBasedOn\":\"[Value]\",\"TaxValue\":\"10.00000\",\"TaxBillingAmount\":\"3500.00\",\"TaxBaseAmount\":\"3500.00\",\"TaxFormula\":\"[Value]\",\"TaxAccountMapped\":\"1107010003\"}},\"Job\":{\"JobInfo\":{\"JobNumber\":\"TST-RE-2000420\",\"JobType\":\"ROE\",\"JobChargeCurrency\":\"IDR\",\"JobChargeAmount\":\"35000.00\",\"BookingNumber\":\"TST-BKG-2044105\"}},\"References\":[]},{\"SeqNo\":\"3\",\"ChargeCode\":\"O00018\",\"ChargeDescription\":\"SURCHARGES\",\"Quantity\":\"1.00000\",\"Uom\":\"FIXED\",\"Rate\":\"50000.00000\",\"Currency\":\"IDR\",\"ChargeAmount\":\"50000.00\",\"ChargeBillingExchangeRate\":\"1.00000000\",\"BillingAmount\":\"50000.00\",\"BillingExchangeRate\":\"1.00000000\",\"BaseAmount\":\"50000.00\",\"PostingCode\":\"6001280001\",\"ChargeTaxes\":{\"ChargeTaxInfo\":{\"TaxGroup\":\"VAT10\",\"TaxCode\":\"N\",\"TaxDescription\":\"N10\",\"TaxPercentage\":\"10.00000\",\"TaxBasedOn\":\"[Value]\",\"TaxValue\":\"10.00000\",\"TaxBillingAmount\":\"5000.00\",\"TaxBaseAmount\":\"5000.00\",\"TaxFormula\":\"[Value]\",\"TaxAccountMapped\":\"1107010003\"}},\"Job\":{\"JobInfo\":{\"JobNumber\":\"TST-RE-2000420\",\"JobType\":\"ROE\",\"JobChargeCurrency\":\"IDR\",\"JobChargeAmount\":\"50000.00\",\"BookingNumber\":\"TST-BKG-2044105\"}},\"References\":[]},{\"SeqNo\":\"4\",\"ChargeCode\":\"O00008\",\"ChargeDescription\":\"WEIGHING SURCHARGES\",\"Quantity\":\"1.00000\",\"Uom\":\"FIXED\",\"Rate\":\"50000.00000\",\"Currency\":\"IDR\",\"ChargeAmount\":\"50000.00\",\"ChargeBillingExchangeRate\":\"1.00000000\",\"BillingAmount\":\"50000.00\",\"BillingExchangeRate\":\"1.00000000\",\"BaseAmount\":\"50000.00\",\"PostingCode\":\"6001280001\",\"ChargeTaxes\":{\"ChargeTaxInfo\":{\"TaxGroup\":\"VAT10\",\"TaxCode\":\"N\",\"TaxDescription\":\"N10\",\"TaxPercentage\":\"10.00000\",\"TaxBasedOn\":\"[Value]\",\"TaxValue\":\"10.00000\",\"TaxBillingAmount\":\"5000.00\",\"TaxBaseAmount\":\"5000.00\",\"TaxFormula\":\"[Value]\",\"TaxAccountMapped\":\"1107010003\"}},\"Job\":{\"JobInfo\":{\"JobNumber\":\"TST-RE-2000420\",\"JobType\":\"ROE\",\"JobChargeCurrency\":\"IDR\",\"JobChargeAmount\":\"50000.00\",\"BookingNumber\":\"TST-BKG-2044105\"}},\"References\":[]},{\"SeqNo\":\"5\",\"ChargeCode\":\"AD0001\",\"ChargeDescription\":\"Administration\",\"Quantity\":\"1.00000\",\"Uom\":\"FIXED\",\"Rate\":\"20000.00000\",\"Currency\":\"IDR\",\"ChargeAmount\":\"20000.00\",\"ChargeBillingExchangeRate\":\"1.00000000\",\"BillingAmount\":\"20000.00\",\"BillingExchangeRate\":\"1.00000000\",\"BaseAmount\":\"20000.00\",\"PostingCode\":\"6001280001\",\"ChargeTaxes\":{\"ChargeTaxInfo\":{\"TaxGroup\":\"VAT10\",\"TaxCode\":\"N\",\"TaxDescription\":\"N10\",\"TaxPercentage\":\"10.00000\",\"TaxBasedOn\":\"[Value]\",\"TaxValue\":\"10.00000\",\"TaxBillingAmount\":\"2000.00\",\"TaxBaseAmount\":\"2000.00\",\"TaxFormula\":\"[Value]\",\"TaxAccountMapped\":\"1107010003\"}},\"Job\":{\"JobInfo\":{\"JobNumber\":\"TST-RE-2000420\",\"JobType\":\"ROE\",\"JobChargeCurrency\":\"IDR\",\"JobChargeAmount\":\"20000.00\",\"BookingNumber\":\"TST-BKG-2044105\"}},\"References\":[]},{\"SeqNo\":\"6\",\"ChargeCode\":\"MAT0032\",\"ChargeDescription\":\"MATERIAL CHARGES\",\"Quantity\":\"1.00000\",\"Uom\":\"FIXED\",\"Rate\":\"3000.00000\",\"Currency\":\"IDR\",\"ChargeAmount\":\"3000.00\",\"ChargeBillingExchangeRate\":\"1.00000000\",\"BillingAmount\":\"3000.00\",\"BillingExchangeRate\":\"1.00000000\",\"BaseAmount\":\"3000.00\",\"PostingCode\":\"6001280001\",\"ChargeTaxes\":{\"ChargeTaxInfo\":[]},\"Job\":{\"JobInfo\":{\"JobNumber\":\"TST-RE-2000420\",\"JobType\":\"ROE\",\"JobChargeCurrency\":\"IDR\",\"JobChargeAmount\":\"3000.00\",\"BookingNumber\":\"TST-BKG-2044105\"}},\"References\":[]}]},\"JobSummary\":{\"JobSummaryInfo\":{\"JobNumber\":\"TST-RE-2000420\",\"JobType\":\"SEA\",\"ClientCode\":\"343974\",\"ClientName\":\"SINO AGRO\",\"ShipperCode\":\"SHIP0001\",\"ShipperName\":\"Shipper 1\",\"ConsigneeCode\":\"SHIP0001\",\"ConsigneeName\":\"Shipper 1\",\"PoNumber\":\"PO1231235\",\"BookingNo\":\"TST-BKG-2044105\",\"BookingDate\":\"20200708\",\"ShipmentOrderNo\":\"PO1231235\",\"EtdDate\":\"20200709000000\",\"EtaDate\":\"20200709000000\",\"AtdDate\":\"20200709000000\",\"AtaDate\":\"20200709000000\",\"PortOfOriginCode\":\"IDSUB\",\"PortOfOriginName\":\"SURABAYA\",\"PortOfDestinationCode\":\"PHMNS\",\"PortOfDestinationName\":\"Manila South Harbour\",\"CountryOfOriginCode\":\"ID\",\"CountryOfOriginName\":\"Indonesia\",\"CountryOfDestinationCode\":\"PH\",\"CountryOfDestinationName\":\"Philippines\",\"PlaceOfReceiptCode\":\"SEC__07\",\"PlaceOfReceiptName\":\"Surabaya Sektor 7\",\"PlaceOfDeliveryCode\":\"SUBT\",\"PlaceOfDeliveryName\":\"TERMINAL SURABAYA\",\"Package\":\"13980\",\"PackageUom\":\"CTN\",\"VolumeUom\":\"CBM\",\"NetWeight\":\"209700.00000\",\"GrossWeight\":\"218227.80000\",\"ChWeight\":\"218227.80000\",\"WeightUom\":\"KGS\",\"MovementType\":\"DS\",\"ContainerSummary\":\"1 X DRYC - 20; \",\"ShipmentType\":\"DIRECT\",\"JobCreatedOn\":\"20200708083213\",\"JobCreatedBy\":\"060102499\",\"SalesPersonCode\":\"110403996\",\"SalesPersonName\":\"Alex\",\"Status\":\"Initiated\",\"TransportationMode\":\"Road\",\"Manifest\":{\"ManifestInfo\":[]},\"JobReferences\":{\"JobReferenceInfo\":[{\"RefFieldName\":\"Booking Ref. No\",\"RefFieldValue\":[]},{\"RefFieldName\":\"Vessel\",\"RefFieldValue\":\"ELIZA V.0899-022A\"},{\"RefFieldName\":\"Business Segment\",\"RefFieldValue\":\"International\"},{\"RefFieldName\":\"ClientCode\",\"RefFieldValue\":\"TC\"},{\"RefFieldName\":\"ExecutingOfficeCode\",\"RefFieldValue\":\"SUB\"}]},\"OwnerOfficeCode\":\"IBJKT\",\"OwnerOfficeName\":\"IB Jakarta\",\"ExecutingOfficeCode\":\"IBJKT\",\"ExecutingOfficeName\":\"IB Jakarta\",\"BookingConfirmationDate\":\"20200708\"}},\"InvoiceReferences\":[]}}}', '{\"Fitrxlgc\":{\"item\":[{\"LgcBelnr\":\"1\",\"LgcBuzei\":1,\"Bldat\":\"2020-07-24\",\"Blart\":\"ZL\",\"Budat\":\"2020-07-24\",\"Monat\":\"07\",\"Waers\":\"IDR\",\"Xblnr\":\"TST-CI-2025561\",\"Bktxt\":\"TST-RE-2000420\",\"Bukrs\":\"IBTO\",\"Hkont\":\"9001280001\",\"Wrbtr\":2860,\"Valut\":\"2020-07-24\",\"Prctr\":\"\",\"Kostl\":\"PSHIT00F05\",\"Zuonr\":\"TST-CI-2025561\",\"Sgtxt\":\"Detail Teks\",\"Shkzg\":\"S\",\"Lifnr\":\"\",\"Kunnr\":\"\",\"RefLgcBelnr\":\"\",\"FiBelnr\":\"\",\"FiGjahr\":\"\",\"Umskz\":\"\",\"RefKey1\":\"40\"},{\"LgcBelnr\":\"1\",\"LgcBuzei\":2,\"Bldat\":\"2020-07-24\",\"Blart\":\"ZL\",\"Budat\":\"2020-07-24\",\"Monat\":\"07\",\"Waers\":\"IDR\",\"Xblnr\":\"TST-CI-2025561\",\"Bktxt\":\"TST-RE-2000420\",\"Bukrs\":\"IBTO\",\"Hkont\":\"6001280001\",\"Wrbtr\":350,\"Valut\":\"2020-07-24\",\"Prctr\":\"\",\"Kostl\":\"PSHIT00F05\",\"Zuonr\":\"TST-CI-2025561\",\"Sgtxt\":\"Detail Teks\",\"Shkzg\":\"S\",\"Lifnr\":\"\",\"Kunnr\":\"\",\"RefLgcBelnr\":\"\",\"FiBelnr\":\"\",\"FiGjahr\":\"\",\"Umskz\":\"\",\"RefKey1\":\"40\"},{\"LgcBelnr\":\"1\",\"LgcBuzei\":3,\"Bldat\":\"2020-07-24\",\"Blart\":\"ZL\",\"Budat\":\"2020-07-24\",\"Monat\":\"07\",\"Waers\":\"IDR\",\"Xblnr\":\"TST-CI-2025561\",\"Bktxt\":\"TST-RE-2000420\",\"Bukrs\":\"IBTO\",\"Hkont\":\"6001280001\",\"Wrbtr\":500,\"Valut\":\"2020-07-24\",\"Prctr\":\"\",\"Kostl\":\"PSHIT00F05\",\"Zuonr\":\"TST-CI-2025561\",\"Sgtxt\":\"Detail Teks\",\"Shkzg\":\"S\",\"Lifnr\":\"\",\"Kunnr\":\"\",\"RefLgcBelnr\":\"\",\"FiBelnr\":\"\",\"FiGjahr\":\"\",\"Umskz\":\"\",\"RefKey1\":\"40\"},{\"LgcBelnr\":\"1\",\"LgcBuzei\":4,\"Bldat\":\"2020-07-24\",\"Blart\":\"ZL\",\"Budat\":\"2020-07-24\",\"Monat\":\"07\",\"Waers\":\"IDR\",\"Xblnr\":\"TST-CI-2025561\",\"Bktxt\":\"TST-RE-2000420\",\"Bukrs\":\"IBTO\",\"Hkont\":\"6001280001\",\"Wrbtr\":500,\"Valut\":\"2020-07-24\",\"Prctr\":\"\",\"Kostl\":\"PSHIT00F05\",\"Zuonr\":\"TST-CI-2025561\",\"Sgtxt\":\"Detail Teks\",\"Shkzg\":\"S\",\"Lifnr\":\"\",\"Kunnr\":\"\",\"RefLgcBelnr\":\"\",\"FiBelnr\":\"\",\"FiGjahr\":\"\",\"Umskz\":\"\",\"RefKey1\":\"40\"},{\"LgcBelnr\":\"1\",\"LgcBuzei\":5,\"Bldat\":\"2020-07-24\",\"Blart\":\"ZL\",\"Budat\":\"2020-07-24\",\"Monat\":\"07\",\"Waers\":\"IDR\",\"Xblnr\":\"TST-CI-2025561\",\"Bktxt\":\"TST-RE-2000420\",\"Bukrs\":\"IBTO\",\"Hkont\":\"6001280001\",\"Wrbtr\":200,\"Valut\":\"2020-07-24\",\"Prctr\":\"\",\"Kostl\":\"PSHIT00F05\",\"Zuonr\":\"TST-CI-2025561\",\"Sgtxt\":\"Detail Teks\",\"Shkzg\":\"S\",\"Lifnr\":\"\",\"Kunnr\":\"\",\"RefLgcBelnr\":\"\",\"FiBelnr\":\"\",\"FiGjahr\":\"\",\"Umskz\":\"\",\"RefKey1\":\"40\"},{\"LgcBelnr\":\"1\",\"LgcBuzei\":6,\"Bldat\":\"2020-07-24\",\"Blart\":\"ZL\",\"Budat\":\"2020-07-24\",\"Monat\":\"07\",\"Waers\":\"IDR\",\"Xblnr\":\"TST-CI-2025561\",\"Bktxt\":\"TST-RE-2000420\",\"Bukrs\":\"IBTO\",\"Hkont\":\"6001280001\",\"Wrbtr\":30,\"Valut\":\"2020-07-24\",\"Prctr\":\"\",\"Kostl\":\"PSHIT00F05\",\"Zuonr\":\"TST-CI-2025561\",\"Sgtxt\":\"Detail Teks\",\"Shkzg\":\"S\",\"Lifnr\":\"\",\"Kunnr\":\"\",\"RefLgcBelnr\":\"\",\"FiBelnr\":\"\",\"FiGjahr\":\"\",\"Umskz\":\"\",\"RefKey1\":\"40\"},{\"LgcBelnr\":\"1\",\"LgcBuzei\":7,\"Bldat\":\"2020-07-24\",\"Blart\":\"ZL\",\"Budat\":\"2020-07-24\",\"Monat\":\"07\",\"Waers\":\"IDR\",\"Xblnr\":\"TST-CI-2025561\",\"Bktxt\":\"TST-RE-2000420\",\"Bukrs\":\"IBTO\",\"Hkont\":\"1107010003\",\"Wrbtr\":286,\"Valut\":\"2020-07-24\",\"Prctr\":\"\",\"Kostl\":\"\",\"Zuonr\":\"TST-CI-2025561\",\"Sgtxt\":\"Vat - In\",\"Shkzg\":\"S\",\"Lifnr\":\"\",\"Kunnr\":\"\",\"RefLgcBelnr\":\"\",\"FiBelnr\":\"\",\"FiGjahr\":\"\",\"Umskz\":\"\",\"RefKey1\":\"40\"},{\"LgcBelnr\":\"1\",\"LgcBuzei\":8,\"Bldat\":\"2020-07-24\",\"Blart\":\"ZL\",\"Budat\":\"2020-07-24\",\"Monat\":\"07\",\"Waers\":\"IDR\",\"Xblnr\":\"TST-CI-2025561\",\"Bktxt\":\"TST-RE-2000420\",\"Bukrs\":\"IBTO\",\"Hkont\":\"1107010003\",\"Wrbtr\":35,\"Valut\":\"2020-07-24\",\"Prctr\":\"\",\"Kostl\":\"\",\"Zuonr\":\"TST-CI-2025561\",\"Sgtxt\":\"Vat - In\",\"Shkzg\":\"S\",\"Lifnr\":\"\",\"Kunnr\":\"\",\"RefLgcBelnr\":\"\",\"FiBelnr\":\"\",\"FiGjahr\":\"\",\"Umskz\":\"\",\"RefKey1\":\"40\"},{\"LgcBelnr\":\"1\",\"LgcBuzei\":9,\"Bldat\":\"2020-07-24\",\"Blart\":\"ZL\",\"Budat\":\"2020-07-24\",\"Monat\":\"07\",\"Waers\":\"IDR\",\"Xblnr\":\"TST-CI-2025561\",\"Bktxt\":\"TST-RE-2000420\",\"Bukrs\":\"IBTO\",\"Hkont\":\"1107010003\",\"Wrbtr\":50,\"Valut\":\"2020-07-24\",\"Prctr\":\"\",\"Kostl\":\"\",\"Zuonr\":\"TST-CI-2025561\",\"Sgtxt\":\"Vat - In\",\"Shkzg\":\"S\",\"Lifnr\":\"\",\"Kunnr\":\"\",\"RefLgcBelnr\":\"\",\"FiBelnr\":\"\",\"FiGjahr\":\"\",\"Umskz\":\"\",\"RefKey1\":\"40\"},{\"LgcBelnr\":\"1\",\"LgcBuzei\":10,\"Bldat\":\"2020-07-24\",\"Blart\":\"ZL\",\"Budat\":\"2020-07-24\",\"Monat\":\"07\",\"Waers\":\"IDR\",\"Xblnr\":\"TST-CI-2025561\",\"Bktxt\":\"TST-RE-2000420\",\"Bukrs\":\"IBTO\",\"Hkont\":\"1107010003\",\"Wrbtr\":50,\"Valut\":\"2020-07-24\",\"Prctr\":\"\",\"Kostl\":\"\",\"Zuonr\":\"TST-CI-2025561\",\"Sgtxt\":\"Vat - In\",\"Shkzg\":\"S\",\"Lifnr\":\"\",\"Kunnr\":\"\",\"RefLgcBelnr\":\"\",\"FiBelnr\":\"\",\"FiGjahr\":\"\",\"Umskz\":\"\",\"RefKey1\":\"40\"},{\"LgcBelnr\":\"1\",\"LgcBuzei\":11,\"Bldat\":\"2020-07-24\",\"Blart\":\"ZL\",\"Budat\":\"2020-07-24\",\"Monat\":\"07\",\"Waers\":\"IDR\",\"Xblnr\":\"TST-CI-2025561\",\"Bktxt\":\"TST-RE-2000420\",\"Bukrs\":\"IBTO\",\"Hkont\":\"1107010003\",\"Wrbtr\":20,\"Valut\":\"2020-07-24\",\"Prctr\":\"\",\"Kostl\":\"\",\"Zuonr\":\"TST-CI-2025561\",\"Sgtxt\":\"Vat - In\",\"Shkzg\":\"S\",\"Lifnr\":\"\",\"Kunnr\":\"\",\"RefLgcBelnr\":\"\",\"FiBelnr\":\"\",\"FiGjahr\":\"\",\"Umskz\":\"\",\"RefKey1\":\"40\"},{\"LgcBelnr\":\"1\",\"LgcBuzei\":12,\"Bldat\":\"2020-07-24\",\"Blart\":\"ZL\",\"Budat\":\"2020-07-24\",\"Monat\":\"07\",\"Waers\":\"IDR\",\"Xblnr\":\"TST-CI-2025561\",\"Bktxt\":\"TST-RE-2000420\",\"Bukrs\":\"IBTO\",\"Hkont\":\"2105010002\",\"Wrbtr\":4881,\"Valut\":\"2020-07-24\",\"Prctr\":\"\",\"Kostl\":\"\",\"Zuonr\":\"TST-CI-2025561\",\"Sgtxt\":\"Tex_Head\",\"Shkzg\":\"H\",\"Lifnr\":\"0800000100\",\"Kunnr\":\"\",\"RefLgcBelnr\":\"\",\"FiBelnr\":\"\",\"FiGjahr\":\"\",\"Umskz\":\"\",\"RefKey1\":\"31\"}]},\"Return\":{\"item\":[{\" Type\":\"\",\" Id\":\"\",\" Number\":\"\",\" Message\":\"\",\" LogNo\":\"\",\" LogMsgNo\":\"\",\" MessageV1\":\"\",\" MessageV2\":\"\",\" MessageV3\":\"\",\" MessageV4\":\"\",\" Parameter\":\"\",\" Row\":\"\",\" Field\":\"\",\" System\":\"\"},{\" Type\":\"\",\" Id\":\"\",\" Number\":\"\",\" Message\":\"\",\" LogNo\":\"\",\" LogMsgNo\":\"\",\" MessageV1\":\"\",\" MessageV2\":\"\",\" MessageV3\":\"\",\" MessageV4\":\"\",\" Parameter\":\"\",\" Row\":\"\",\" Field\":\"\",\" System\":\"\"},{\" Type\":\"\",\" Id\":\"\",\" Number\":\"\",\" Message\":\"\",\" LogNo\":\"\",\" LogMsgNo\":\"\",\" MessageV1\":\"\",\" MessageV2\":\"\",\" MessageV3\":\"\",\" MessageV4\":\"\",\" Parameter\":\"\",\" Row\":\"\",\" Field\":\"\",\" System\":\"\"},{\" Type\":\"\",\" Id\":\"\",\" Number\":\"\",\" Message\":\"\",\" LogNo\":\"\",\" LogMsgNo\":\"\",\" MessageV1\":\"\",\" MessageV2\":\"\",\" MessageV3\":\"\",\" MessageV4\":\"\",\" Parameter\":\"\",\" Row\":\"\",\" Field\":\"\",\" System\":\"\"},{\" Type\":\"\",\" Id\":\"\",\" Number\":\"\",\" Message\":\"\",\" LogNo\":\"\",\" LogMsgNo\":\"\",\" MessageV1\":\"\",\" MessageV2\":\"\",\" MessageV3\":\"\",\" MessageV4\":\"\",\" Parameter\":\"\",\" Row\":\"\",\" Field\":\"\",\" System\":\"\"},{\" Type\":\"\",\" Id\":\"\",\" Number\":\"\",\" Message\":\"\",\" LogNo\":\"\",\" LogMsgNo\":\"\",\" MessageV1\":\"\",\" MessageV2\":\"\",\" MessageV3\":\"\",\" MessageV4\":\"\",\" Parameter\":\"\",\" Row\":\"\",\" Field\":\"\",\" System\":\"\"},{\" Type\":\"\",\" Id\":\"\",\" Number\":\"\",\" Message\":\"\",\" LogNo\":\"\",\" LogMsgNo\":\"\",\" MessageV1\":\"\",\" MessageV2\":\"\",\" MessageV3\":\"\",\" MessageV4\":\"\",\" Parameter\":\"\",\" Row\":\"\",\" Field\":\"\",\" System\":\"\"},{\" Type\":\"\",\" Id\":\"\",\" Number\":\"\",\" Message\":\"\",\" LogNo\":\"\",\" LogMsgNo\":\"\",\" MessageV1\":\"\",\" MessageV2\":\"\",\" MessageV3\":\"\",\" MessageV4\":\"\",\" Parameter\":\"\",\" Row\":\"\",\" Field\":\"\",\" System\":\"\"},{\" Type\":\"\",\" Id\":\"\",\" Number\":\"\",\" Message\":\"\",\" LogNo\":\"\",\" LogMsgNo\":\"\",\" MessageV1\":\"\",\" MessageV2\":\"\",\" MessageV3\":\"\",\" MessageV4\":\"\",\" Parameter\":\"\",\" Row\":\"\",\" Field\":\"\",\" System\":\"\"},{\" Type\":\"\",\" Id\":\"\",\" Number\":\"\",\" Message\":\"\",\" LogNo\":\"\",\" LogMsgNo\":\"\",\" MessageV1\":\"\",\" MessageV2\":\"\",\" MessageV3\":\"\",\" MessageV4\":\"\",\" Parameter\":\"\",\" Row\":\"\",\" Field\":\"\",\" System\":\"\"},{\" Type\":\"\",\" Id\":\"\",\" Number\":\"\",\" Message\":\"\",\" LogNo\":\"\",\" LogMsgNo\":\"\",\" MessageV1\":\"\",\" MessageV2\":\"\",\" MessageV3\":\"\",\" MessageV4\":\"\",\" Parameter\":\"\",\" Row\":\"\",\" Field\":\"\",\" System\":\"\"},{\" Type\":\"\",\" Id\":\"\",\" Number\":\"\",\" Message\":\"\",\" LogNo\":\"\",\" LogMsgNo\":\"\",\" MessageV1\":\"\",\" MessageV2\":\"\",\" MessageV3\":\"\",\" MessageV4\":\"\",\" Parameter\":\"\",\" Row\":\"\",\" Field\":\"\",\" System\":\"\"}]},\"Test\":\"\"}');
INSERT INTO `tb_interfaces` (`id`, `code`, `proTime`, `interfaces`, `directions`, `descriptions`, `messages`, `frontend_text`, `backend_text`) VALUES
('5f9fd27c54bbc', 'TST-CI-2025561', '2020-11-02 16:33:48', 'payable', 'SAP_FIPOST', 'TST-CI-2025561', '[\"Error in document: BKPFF 0000 S4DCLNT320\",\"G\\/L account 9001280001 is not defined in chart of accounts IBCA\",\"G\\/L account 9001280001 is not defined in chart of accounts IBCA\",\"Account 9001280001 does not exist in chart of accounts IBCA\"]', '{\"Header\":{\"MessageType\":\"AP\",\"MessageVersion\":\"1\",\"MessageIdentifier\":\"b0bab1d8-320d-4851-a79d-148396e61308\",\"SentDatetime\":\"2020-07-24T11:51:01.5838572Z\",\"SentDatetimeZone\":\"(UTC+07:00) Bangkok, Hanoi, Jakarta\",\"Partners\":{\"PartnerInformation\":{\"ContactInformation\":[]}}},\"Invoices\":{\"InvoiceInfo\":{\"ActionCode\":\"1\",\"Office\":\"SUIT\",\"OperationOffice\":\"IBJKT\",\"InvoiceNo\":\"TST-CI-2025561\",\"InvoiceDate\":\"20200724\",\"InvoiceDueDate\":\"20200812\",\"CreatedBy\":\"User\",\"CreatedOn\":\"20200724114302\",\"ApprovedBy\":\"User\",\"ApprovedOn\":\"20200724114942\",\"PostedBy\":\"User\",\"PostedOn\":\"20200724114942\",\"InvoiceType\":\"Invoice\",\"InvoiceReferenceNo\":\"000056378\",\"InvoiceReferenceDate\":\"20200713\",\"YearCode\":\"1\",\"VoucherNo\":[],\"IsOperationInvoice\":\"Y\",\"IsLineLevelGst\":\"Y\",\"AmountSummary\":{\"BillingInvoiceCurrency\":\"IDR\",\"BillingCurrencyExchangeRate\":\"1.00000000\",\"BaseCurrencyCode\":\"IDR\",\"TotalGrossAmount\":\"444000.00\",\"BaseTotalGrossAmount\":\"444000.00\",\"TotalDiscountAmount\":\"0.00\",\"BaseTotalDiscountAmount\":\"0.00\",\"TotalTaxAmount\":\"44100.00\",\"BaseTotalTaxAmount\":\"44100.00\",\"GrandInvoiceAmount\":\"488100.00\",\"BaseGrandInvoiceAmount\":\"488100.00\",\"TaxSummary\":{\"TaxInfo\":{\"Group\":\"VAT10 @ 10.0000%\",\"Code\":\"N\",\"Percentage\":\"10.00000\",\"BillingSummTaxAmount\":\"44100.00\",\"BaseSummTaxAmount\":\"44100.00\"}},\"DiscountSummary\":[],\"WithholdingTaxTdsSummary\":[]},\"Vendor\":{\"AccountType\":\"VENDOR\",\"AccountCode\":\"2105010002\",\"Code\":\"0800000100\",\"Name\":\"AURIONPRO SOLUTIONS PT\",\"Address\":\"SURABAYA\",\"CreditTerms\":\"30\",\"References\":[]},\"Charges\":{\"ChargeInfo\":[{\"SeqNo\":\"1\",\"ChargeCode\":\"L00021\",\"ChargeDescription\":\"Lifting\",\"Quantity\":\"1.00000\",\"Uom\":\"FIXED\",\"Rate\":\"286000.00000\",\"Currency\":\"IDR\",\"ChargeAmount\":\"286000.00\",\"ChargeBillingExchangeRate\":\"1.00000000\",\"BillingAmount\":\"286000.00\",\"BillingExchangeRate\":\"1.00000000\",\"BaseAmount\":\"286000.00\",\"PostingCode\":\"9001280001\",\"ChargeTaxes\":{\"ChargeTaxInfo\":{\"TaxGroup\":\"VAT10\",\"TaxCode\":\"N\",\"TaxDescription\":\"N10\",\"TaxPercentage\":\"10.00000\",\"TaxBasedOn\":\"[Value]\",\"TaxValue\":\"10.00000\",\"TaxBillingAmount\":\"28600.00\",\"TaxBaseAmount\":\"28600.00\",\"TaxFormula\":\"[Value]\",\"TaxAccountMapped\":\"1107010003\"}},\"Job\":{\"JobInfo\":{\"JobNumber\":\"TST-RE-2000420\",\"JobType\":\"ROE\",\"JobChargeCurrency\":\"IDR\",\"JobChargeAmount\":\"286000.00\",\"BookingNumber\":\"TST-BKG-2044105\"}},\"References\":[]},{\"SeqNo\":\"2\",\"ChargeCode\":\"O00004\",\"ChargeDescription\":\"DOCK\",\"Quantity\":\"1.00000\",\"Uom\":\"FIXED\",\"Rate\":\"35000.00000\",\"Currency\":\"IDR\",\"ChargeAmount\":\"35000.00\",\"ChargeBillingExchangeRate\":\"1.00000000\",\"BillingAmount\":\"35000.00\",\"BillingExchangeRate\":\"1.00000000\",\"BaseAmount\":\"35000.00\",\"PostingCode\":\"6001280001\",\"ChargeTaxes\":{\"ChargeTaxInfo\":{\"TaxGroup\":\"VAT10\",\"TaxCode\":\"N\",\"TaxDescription\":\"N10\",\"TaxPercentage\":\"10.00000\",\"TaxBasedOn\":\"[Value]\",\"TaxValue\":\"10.00000\",\"TaxBillingAmount\":\"3500.00\",\"TaxBaseAmount\":\"3500.00\",\"TaxFormula\":\"[Value]\",\"TaxAccountMapped\":\"1107010003\"}},\"Job\":{\"JobInfo\":{\"JobNumber\":\"TST-RE-2000420\",\"JobType\":\"ROE\",\"JobChargeCurrency\":\"IDR\",\"JobChargeAmount\":\"35000.00\",\"BookingNumber\":\"TST-BKG-2044105\"}},\"References\":[]},{\"SeqNo\":\"3\",\"ChargeCode\":\"O00018\",\"ChargeDescription\":\"SURCHARGES\",\"Quantity\":\"1.00000\",\"Uom\":\"FIXED\",\"Rate\":\"50000.00000\",\"Currency\":\"IDR\",\"ChargeAmount\":\"50000.00\",\"ChargeBillingExchangeRate\":\"1.00000000\",\"BillingAmount\":\"50000.00\",\"BillingExchangeRate\":\"1.00000000\",\"BaseAmount\":\"50000.00\",\"PostingCode\":\"6001280001\",\"ChargeTaxes\":{\"ChargeTaxInfo\":{\"TaxGroup\":\"VAT10\",\"TaxCode\":\"N\",\"TaxDescription\":\"N10\",\"TaxPercentage\":\"10.00000\",\"TaxBasedOn\":\"[Value]\",\"TaxValue\":\"10.00000\",\"TaxBillingAmount\":\"5000.00\",\"TaxBaseAmount\":\"5000.00\",\"TaxFormula\":\"[Value]\",\"TaxAccountMapped\":\"1107010003\"}},\"Job\":{\"JobInfo\":{\"JobNumber\":\"TST-RE-2000420\",\"JobType\":\"ROE\",\"JobChargeCurrency\":\"IDR\",\"JobChargeAmount\":\"50000.00\",\"BookingNumber\":\"TST-BKG-2044105\"}},\"References\":[]},{\"SeqNo\":\"4\",\"ChargeCode\":\"O00008\",\"ChargeDescription\":\"WEIGHING SURCHARGES\",\"Quantity\":\"1.00000\",\"Uom\":\"FIXED\",\"Rate\":\"50000.00000\",\"Currency\":\"IDR\",\"ChargeAmount\":\"50000.00\",\"ChargeBillingExchangeRate\":\"1.00000000\",\"BillingAmount\":\"50000.00\",\"BillingExchangeRate\":\"1.00000000\",\"BaseAmount\":\"50000.00\",\"PostingCode\":\"6001280001\",\"ChargeTaxes\":{\"ChargeTaxInfo\":{\"TaxGroup\":\"VAT10\",\"TaxCode\":\"N\",\"TaxDescription\":\"N10\",\"TaxPercentage\":\"10.00000\",\"TaxBasedOn\":\"[Value]\",\"TaxValue\":\"10.00000\",\"TaxBillingAmount\":\"5000.00\",\"TaxBaseAmount\":\"5000.00\",\"TaxFormula\":\"[Value]\",\"TaxAccountMapped\":\"1107010003\"}},\"Job\":{\"JobInfo\":{\"JobNumber\":\"TST-RE-2000420\",\"JobType\":\"ROE\",\"JobChargeCurrency\":\"IDR\",\"JobChargeAmount\":\"50000.00\",\"BookingNumber\":\"TST-BKG-2044105\"}},\"References\":[]},{\"SeqNo\":\"5\",\"ChargeCode\":\"AD0001\",\"ChargeDescription\":\"Administration\",\"Quantity\":\"1.00000\",\"Uom\":\"FIXED\",\"Rate\":\"20000.00000\",\"Currency\":\"IDR\",\"ChargeAmount\":\"20000.00\",\"ChargeBillingExchangeRate\":\"1.00000000\",\"BillingAmount\":\"20000.00\",\"BillingExchangeRate\":\"1.00000000\",\"BaseAmount\":\"20000.00\",\"PostingCode\":\"6001280001\",\"ChargeTaxes\":{\"ChargeTaxInfo\":{\"TaxGroup\":\"VAT10\",\"TaxCode\":\"N\",\"TaxDescription\":\"N10\",\"TaxPercentage\":\"10.00000\",\"TaxBasedOn\":\"[Value]\",\"TaxValue\":\"10.00000\",\"TaxBillingAmount\":\"2000.00\",\"TaxBaseAmount\":\"2000.00\",\"TaxFormula\":\"[Value]\",\"TaxAccountMapped\":\"1107010003\"}},\"Job\":{\"JobInfo\":{\"JobNumber\":\"TST-RE-2000420\",\"JobType\":\"ROE\",\"JobChargeCurrency\":\"IDR\",\"JobChargeAmount\":\"20000.00\",\"BookingNumber\":\"TST-BKG-2044105\"}},\"References\":[]},{\"SeqNo\":\"6\",\"ChargeCode\":\"MAT0032\",\"ChargeDescription\":\"MATERIAL CHARGES\",\"Quantity\":\"1.00000\",\"Uom\":\"FIXED\",\"Rate\":\"3000.00000\",\"Currency\":\"IDR\",\"ChargeAmount\":\"3000.00\",\"ChargeBillingExchangeRate\":\"1.00000000\",\"BillingAmount\":\"3000.00\",\"BillingExchangeRate\":\"1.00000000\",\"BaseAmount\":\"3000.00\",\"PostingCode\":\"6001280001\",\"ChargeTaxes\":{\"ChargeTaxInfo\":[]},\"Job\":{\"JobInfo\":{\"JobNumber\":\"TST-RE-2000420\",\"JobType\":\"ROE\",\"JobChargeCurrency\":\"IDR\",\"JobChargeAmount\":\"3000.00\",\"BookingNumber\":\"TST-BKG-2044105\"}},\"References\":[]}]},\"JobSummary\":{\"JobSummaryInfo\":{\"JobNumber\":\"TST-RE-2000420\",\"JobType\":\"SEA\",\"ClientCode\":\"343974\",\"ClientName\":\"SINO AGRO\",\"ShipperCode\":\"SHIP0001\",\"ShipperName\":\"Shipper 1\",\"ConsigneeCode\":\"SHIP0001\",\"ConsigneeName\":\"Shipper 1\",\"PoNumber\":\"PO1231235\",\"BookingNo\":\"TST-BKG-2044105\",\"BookingDate\":\"20200708\",\"ShipmentOrderNo\":\"PO1231235\",\"EtdDate\":\"20200709000000\",\"EtaDate\":\"20200709000000\",\"AtdDate\":\"20200709000000\",\"AtaDate\":\"20200709000000\",\"PortOfOriginCode\":\"IDSUB\",\"PortOfOriginName\":\"SURABAYA\",\"PortOfDestinationCode\":\"PHMNS\",\"PortOfDestinationName\":\"Manila South Harbour\",\"CountryOfOriginCode\":\"ID\",\"CountryOfOriginName\":\"Indonesia\",\"CountryOfDestinationCode\":\"PH\",\"CountryOfDestinationName\":\"Philippines\",\"PlaceOfReceiptCode\":\"SEC__07\",\"PlaceOfReceiptName\":\"Surabaya Sektor 7\",\"PlaceOfDeliveryCode\":\"SUBT\",\"PlaceOfDeliveryName\":\"TERMINAL SURABAYA\",\"Package\":\"13980\",\"PackageUom\":\"CTN\",\"VolumeUom\":\"CBM\",\"NetWeight\":\"209700.00000\",\"GrossWeight\":\"218227.80000\",\"ChWeight\":\"218227.80000\",\"WeightUom\":\"KGS\",\"MovementType\":\"DS\",\"ContainerSummary\":\"1 X DRYC - 20; \",\"ShipmentType\":\"DIRECT\",\"JobCreatedOn\":\"20200708083213\",\"JobCreatedBy\":\"060102499\",\"SalesPersonCode\":\"110403996\",\"SalesPersonName\":\"Alex\",\"Status\":\"Initiated\",\"TransportationMode\":\"Road\",\"Manifest\":{\"ManifestInfo\":[]},\"JobReferences\":{\"JobReferenceInfo\":[{\"RefFieldName\":\"Booking Ref. No\",\"RefFieldValue\":[]},{\"RefFieldName\":\"Vessel\",\"RefFieldValue\":\"ELIZA V.0899-022A\"},{\"RefFieldName\":\"Business Segment\",\"RefFieldValue\":\"International\"},{\"RefFieldName\":\"ClientCode\",\"RefFieldValue\":\"TC\"},{\"RefFieldName\":\"ExecutingOfficeCode\",\"RefFieldValue\":\"SUB\"}]},\"OwnerOfficeCode\":\"IBJKT\",\"OwnerOfficeName\":\"IB Jakarta\",\"ExecutingOfficeCode\":\"IBJKT\",\"ExecutingOfficeName\":\"IB Jakarta\",\"BookingConfirmationDate\":\"20200708\"}},\"InvoiceReferences\":[]}}}', '{\"Fitrxlgc\":{\"item\":[{\"LgcBelnr\":\"1\",\"LgcBuzei\":1,\"Bldat\":\"2020-07-24\",\"Blart\":\"ZL\",\"Budat\":\"2020-07-24\",\"Monat\":\"07\",\"Waers\":\"IDR\",\"Xblnr\":\"TST-CI-2025561\",\"Bktxt\":\"TST-RE-2000420\",\"Bukrs\":\"IBTO\",\"Hkont\":\"9001280001\",\"Wrbtr\":2860,\"Valut\":\"2020-07-24\",\"Prctr\":\"\",\"Kostl\":\"PSHIT00F05\",\"Zuonr\":\"TST-CI-2025561\",\"Sgtxt\":\"Detail Teks\",\"Shkzg\":\"S\",\"Lifnr\":\"\",\"Kunnr\":\"\",\"RefLgcBelnr\":\"\",\"FiBelnr\":\"\",\"FiGjahr\":\"\",\"Umskz\":\"\",\"RefKey1\":\"40\"},{\"LgcBelnr\":\"1\",\"LgcBuzei\":2,\"Bldat\":\"2020-07-24\",\"Blart\":\"ZL\",\"Budat\":\"2020-07-24\",\"Monat\":\"07\",\"Waers\":\"IDR\",\"Xblnr\":\"TST-CI-2025561\",\"Bktxt\":\"TST-RE-2000420\",\"Bukrs\":\"IBTO\",\"Hkont\":\"6001280001\",\"Wrbtr\":350,\"Valut\":\"2020-07-24\",\"Prctr\":\"\",\"Kostl\":\"PSHIT00F05\",\"Zuonr\":\"TST-CI-2025561\",\"Sgtxt\":\"Detail Teks\",\"Shkzg\":\"S\",\"Lifnr\":\"\",\"Kunnr\":\"\",\"RefLgcBelnr\":\"\",\"FiBelnr\":\"\",\"FiGjahr\":\"\",\"Umskz\":\"\",\"RefKey1\":\"40\"},{\"LgcBelnr\":\"1\",\"LgcBuzei\":3,\"Bldat\":\"2020-07-24\",\"Blart\":\"ZL\",\"Budat\":\"2020-07-24\",\"Monat\":\"07\",\"Waers\":\"IDR\",\"Xblnr\":\"TST-CI-2025561\",\"Bktxt\":\"TST-RE-2000420\",\"Bukrs\":\"IBTO\",\"Hkont\":\"6001280001\",\"Wrbtr\":500,\"Valut\":\"2020-07-24\",\"Prctr\":\"\",\"Kostl\":\"PSHIT00F05\",\"Zuonr\":\"TST-CI-2025561\",\"Sgtxt\":\"Detail Teks\",\"Shkzg\":\"S\",\"Lifnr\":\"\",\"Kunnr\":\"\",\"RefLgcBelnr\":\"\",\"FiBelnr\":\"\",\"FiGjahr\":\"\",\"Umskz\":\"\",\"RefKey1\":\"40\"},{\"LgcBelnr\":\"1\",\"LgcBuzei\":4,\"Bldat\":\"2020-07-24\",\"Blart\":\"ZL\",\"Budat\":\"2020-07-24\",\"Monat\":\"07\",\"Waers\":\"IDR\",\"Xblnr\":\"TST-CI-2025561\",\"Bktxt\":\"TST-RE-2000420\",\"Bukrs\":\"IBTO\",\"Hkont\":\"6001280001\",\"Wrbtr\":500,\"Valut\":\"2020-07-24\",\"Prctr\":\"\",\"Kostl\":\"PSHIT00F05\",\"Zuonr\":\"TST-CI-2025561\",\"Sgtxt\":\"Detail Teks\",\"Shkzg\":\"S\",\"Lifnr\":\"\",\"Kunnr\":\"\",\"RefLgcBelnr\":\"\",\"FiBelnr\":\"\",\"FiGjahr\":\"\",\"Umskz\":\"\",\"RefKey1\":\"40\"},{\"LgcBelnr\":\"1\",\"LgcBuzei\":5,\"Bldat\":\"2020-07-24\",\"Blart\":\"ZL\",\"Budat\":\"2020-07-24\",\"Monat\":\"07\",\"Waers\":\"IDR\",\"Xblnr\":\"TST-CI-2025561\",\"Bktxt\":\"TST-RE-2000420\",\"Bukrs\":\"IBTO\",\"Hkont\":\"6001280001\",\"Wrbtr\":200,\"Valut\":\"2020-07-24\",\"Prctr\":\"\",\"Kostl\":\"PSHIT00F05\",\"Zuonr\":\"TST-CI-2025561\",\"Sgtxt\":\"Detail Teks\",\"Shkzg\":\"S\",\"Lifnr\":\"\",\"Kunnr\":\"\",\"RefLgcBelnr\":\"\",\"FiBelnr\":\"\",\"FiGjahr\":\"\",\"Umskz\":\"\",\"RefKey1\":\"40\"},{\"LgcBelnr\":\"1\",\"LgcBuzei\":6,\"Bldat\":\"2020-07-24\",\"Blart\":\"ZL\",\"Budat\":\"2020-07-24\",\"Monat\":\"07\",\"Waers\":\"IDR\",\"Xblnr\":\"TST-CI-2025561\",\"Bktxt\":\"TST-RE-2000420\",\"Bukrs\":\"IBTO\",\"Hkont\":\"6001280001\",\"Wrbtr\":30,\"Valut\":\"2020-07-24\",\"Prctr\":\"\",\"Kostl\":\"PSHIT00F05\",\"Zuonr\":\"TST-CI-2025561\",\"Sgtxt\":\"Detail Teks\",\"Shkzg\":\"S\",\"Lifnr\":\"\",\"Kunnr\":\"\",\"RefLgcBelnr\":\"\",\"FiBelnr\":\"\",\"FiGjahr\":\"\",\"Umskz\":\"\",\"RefKey1\":\"40\"},{\"LgcBelnr\":\"1\",\"LgcBuzei\":7,\"Bldat\":\"2020-07-24\",\"Blart\":\"ZL\",\"Budat\":\"2020-07-24\",\"Monat\":\"07\",\"Waers\":\"IDR\",\"Xblnr\":\"TST-CI-2025561\",\"Bktxt\":\"TST-RE-2000420\",\"Bukrs\":\"IBTO\",\"Hkont\":\"1107010003\",\"Wrbtr\":286,\"Valut\":\"2020-07-24\",\"Prctr\":\"\",\"Kostl\":\"\",\"Zuonr\":\"TST-CI-2025561\",\"Sgtxt\":\"Vat - In\",\"Shkzg\":\"S\",\"Lifnr\":\"\",\"Kunnr\":\"\",\"RefLgcBelnr\":\"\",\"FiBelnr\":\"\",\"FiGjahr\":\"\",\"Umskz\":\"\",\"RefKey1\":\"40\"},{\"LgcBelnr\":\"1\",\"LgcBuzei\":8,\"Bldat\":\"2020-07-24\",\"Blart\":\"ZL\",\"Budat\":\"2020-07-24\",\"Monat\":\"07\",\"Waers\":\"IDR\",\"Xblnr\":\"TST-CI-2025561\",\"Bktxt\":\"TST-RE-2000420\",\"Bukrs\":\"IBTO\",\"Hkont\":\"1107010003\",\"Wrbtr\":35,\"Valut\":\"2020-07-24\",\"Prctr\":\"\",\"Kostl\":\"\",\"Zuonr\":\"TST-CI-2025561\",\"Sgtxt\":\"Vat - In\",\"Shkzg\":\"S\",\"Lifnr\":\"\",\"Kunnr\":\"\",\"RefLgcBelnr\":\"\",\"FiBelnr\":\"\",\"FiGjahr\":\"\",\"Umskz\":\"\",\"RefKey1\":\"40\"},{\"LgcBelnr\":\"1\",\"LgcBuzei\":9,\"Bldat\":\"2020-07-24\",\"Blart\":\"ZL\",\"Budat\":\"2020-07-24\",\"Monat\":\"07\",\"Waers\":\"IDR\",\"Xblnr\":\"TST-CI-2025561\",\"Bktxt\":\"TST-RE-2000420\",\"Bukrs\":\"IBTO\",\"Hkont\":\"1107010003\",\"Wrbtr\":50,\"Valut\":\"2020-07-24\",\"Prctr\":\"\",\"Kostl\":\"\",\"Zuonr\":\"TST-CI-2025561\",\"Sgtxt\":\"Vat - In\",\"Shkzg\":\"S\",\"Lifnr\":\"\",\"Kunnr\":\"\",\"RefLgcBelnr\":\"\",\"FiBelnr\":\"\",\"FiGjahr\":\"\",\"Umskz\":\"\",\"RefKey1\":\"40\"},{\"LgcBelnr\":\"1\",\"LgcBuzei\":10,\"Bldat\":\"2020-07-24\",\"Blart\":\"ZL\",\"Budat\":\"2020-07-24\",\"Monat\":\"07\",\"Waers\":\"IDR\",\"Xblnr\":\"TST-CI-2025561\",\"Bktxt\":\"TST-RE-2000420\",\"Bukrs\":\"IBTO\",\"Hkont\":\"1107010003\",\"Wrbtr\":50,\"Valut\":\"2020-07-24\",\"Prctr\":\"\",\"Kostl\":\"\",\"Zuonr\":\"TST-CI-2025561\",\"Sgtxt\":\"Vat - In\",\"Shkzg\":\"S\",\"Lifnr\":\"\",\"Kunnr\":\"\",\"RefLgcBelnr\":\"\",\"FiBelnr\":\"\",\"FiGjahr\":\"\",\"Umskz\":\"\",\"RefKey1\":\"40\"},{\"LgcBelnr\":\"1\",\"LgcBuzei\":11,\"Bldat\":\"2020-07-24\",\"Blart\":\"ZL\",\"Budat\":\"2020-07-24\",\"Monat\":\"07\",\"Waers\":\"IDR\",\"Xblnr\":\"TST-CI-2025561\",\"Bktxt\":\"TST-RE-2000420\",\"Bukrs\":\"IBTO\",\"Hkont\":\"1107010003\",\"Wrbtr\":20,\"Valut\":\"2020-07-24\",\"Prctr\":\"\",\"Kostl\":\"\",\"Zuonr\":\"TST-CI-2025561\",\"Sgtxt\":\"Vat - In\",\"Shkzg\":\"S\",\"Lifnr\":\"\",\"Kunnr\":\"\",\"RefLgcBelnr\":\"\",\"FiBelnr\":\"\",\"FiGjahr\":\"\",\"Umskz\":\"\",\"RefKey1\":\"40\"},{\"LgcBelnr\":\"1\",\"LgcBuzei\":12,\"Bldat\":\"2020-07-24\",\"Blart\":\"ZL\",\"Budat\":\"2020-07-24\",\"Monat\":\"07\",\"Waers\":\"IDR\",\"Xblnr\":\"TST-CI-2025561\",\"Bktxt\":\"TST-RE-2000420\",\"Bukrs\":\"IBTO\",\"Hkont\":\"2105010002\",\"Wrbtr\":4881,\"Valut\":\"2020-07-24\",\"Prctr\":\"\",\"Kostl\":\"\",\"Zuonr\":\"TST-CI-2025561\",\"Sgtxt\":\"Tex_Head\",\"Shkzg\":\"H\",\"Lifnr\":\"0800000100\",\"Kunnr\":\"\",\"RefLgcBelnr\":\"\",\"FiBelnr\":\"\",\"FiGjahr\":\"\",\"Umskz\":\"\",\"RefKey1\":\"31\"}]},\"Return\":{\"item\":[{\" Type\":\"\",\" Id\":\"\",\" Number\":\"\",\" Message\":\"\",\" LogNo\":\"\",\" LogMsgNo\":\"\",\" MessageV1\":\"\",\" MessageV2\":\"\",\" MessageV3\":\"\",\" MessageV4\":\"\",\" Parameter\":\"\",\" Row\":\"\",\" Field\":\"\",\" System\":\"\"},{\" Type\":\"\",\" Id\":\"\",\" Number\":\"\",\" Message\":\"\",\" LogNo\":\"\",\" LogMsgNo\":\"\",\" MessageV1\":\"\",\" MessageV2\":\"\",\" MessageV3\":\"\",\" MessageV4\":\"\",\" Parameter\":\"\",\" Row\":\"\",\" Field\":\"\",\" System\":\"\"},{\" Type\":\"\",\" Id\":\"\",\" Number\":\"\",\" Message\":\"\",\" LogNo\":\"\",\" LogMsgNo\":\"\",\" MessageV1\":\"\",\" MessageV2\":\"\",\" MessageV3\":\"\",\" MessageV4\":\"\",\" Parameter\":\"\",\" Row\":\"\",\" Field\":\"\",\" System\":\"\"},{\" Type\":\"\",\" Id\":\"\",\" Number\":\"\",\" Message\":\"\",\" LogNo\":\"\",\" LogMsgNo\":\"\",\" MessageV1\":\"\",\" MessageV2\":\"\",\" MessageV3\":\"\",\" MessageV4\":\"\",\" Parameter\":\"\",\" Row\":\"\",\" Field\":\"\",\" System\":\"\"},{\" Type\":\"\",\" Id\":\"\",\" Number\":\"\",\" Message\":\"\",\" LogNo\":\"\",\" LogMsgNo\":\"\",\" MessageV1\":\"\",\" MessageV2\":\"\",\" MessageV3\":\"\",\" MessageV4\":\"\",\" Parameter\":\"\",\" Row\":\"\",\" Field\":\"\",\" System\":\"\"},{\" Type\":\"\",\" Id\":\"\",\" Number\":\"\",\" Message\":\"\",\" LogNo\":\"\",\" LogMsgNo\":\"\",\" MessageV1\":\"\",\" MessageV2\":\"\",\" MessageV3\":\"\",\" MessageV4\":\"\",\" Parameter\":\"\",\" Row\":\"\",\" Field\":\"\",\" System\":\"\"},{\" Type\":\"\",\" Id\":\"\",\" Number\":\"\",\" Message\":\"\",\" LogNo\":\"\",\" LogMsgNo\":\"\",\" MessageV1\":\"\",\" MessageV2\":\"\",\" MessageV3\":\"\",\" MessageV4\":\"\",\" Parameter\":\"\",\" Row\":\"\",\" Field\":\"\",\" System\":\"\"},{\" Type\":\"\",\" Id\":\"\",\" Number\":\"\",\" Message\":\"\",\" LogNo\":\"\",\" LogMsgNo\":\"\",\" MessageV1\":\"\",\" MessageV2\":\"\",\" MessageV3\":\"\",\" MessageV4\":\"\",\" Parameter\":\"\",\" Row\":\"\",\" Field\":\"\",\" System\":\"\"},{\" Type\":\"\",\" Id\":\"\",\" Number\":\"\",\" Message\":\"\",\" LogNo\":\"\",\" LogMsgNo\":\"\",\" MessageV1\":\"\",\" MessageV2\":\"\",\" MessageV3\":\"\",\" MessageV4\":\"\",\" Parameter\":\"\",\" Row\":\"\",\" Field\":\"\",\" System\":\"\"},{\" Type\":\"\",\" Id\":\"\",\" Number\":\"\",\" Message\":\"\",\" LogNo\":\"\",\" LogMsgNo\":\"\",\" MessageV1\":\"\",\" MessageV2\":\"\",\" MessageV3\":\"\",\" MessageV4\":\"\",\" Parameter\":\"\",\" Row\":\"\",\" Field\":\"\",\" System\":\"\"},{\" Type\":\"\",\" Id\":\"\",\" Number\":\"\",\" Message\":\"\",\" LogNo\":\"\",\" LogMsgNo\":\"\",\" MessageV1\":\"\",\" MessageV2\":\"\",\" MessageV3\":\"\",\" MessageV4\":\"\",\" Parameter\":\"\",\" Row\":\"\",\" Field\":\"\",\" System\":\"\"},{\" Type\":\"\",\" Id\":\"\",\" Number\":\"\",\" Message\":\"\",\" LogNo\":\"\",\" LogMsgNo\":\"\",\" MessageV1\":\"\",\" MessageV2\":\"\",\" MessageV3\":\"\",\" MessageV4\":\"\",\" Parameter\":\"\",\" Row\":\"\",\" Field\":\"\",\" System\":\"\"}]},\"Test\":\"\"}'),
('5fa3622d4801f', 'SUIT-SET-2000010', '2020-11-05 09:23:41', 'settlement', 'SAP_FIPOST', 'SUIT-SET-2000010', '[\"Error in document: BKPFF 0000 S4DCLNT320\",\"Account 5001130020 requires an assignment to a CO object\",\"Account 5001130020 requires an assignment to a CO object\",\"Account 5001130020 requires an assignment to a CO object\",\"Account 5001130020 requires an assignment to a CO object\",\"Account 5001130020 requires an assignment to a CO object\",\"Account 5001130020 requires an assignment to a CO object\"]', '{\"Header\":{\"MessageType\":\"Settlement\",\"MessageVersion\":\"1\",\"MessageIdentifier\":\"c679e2ce-9361-4afa-87c4-082f85ebdec0\",\"MessageDateTime\":\"20201022052004\",\"Partners\":{\"PartnerInformation\":{\"ContactInformation\":[]}}},\"SettlementDetail\":{\"Settlement\":{\"BasicDetails\":{\"SettlementNo\":\"SUIT-SET-2000010\",\"Date\":\"20201015000000\",\"BaseOffice\":{\"Code\":\"SUIT\",\"Name\":\"Iron Bird Jakarta\"},\"OfficeBaseCurrency\":\"IDR\",\"VendorDetails\":{\"Code\":\"Driver\",\"Name\":\"Driver (Own Transport)\",\"Address1\":\"-\",\"Country\":[]},\"ResourceDetails\":{\"ResourceFunction\":\"Driver\",\"Code\":\"Driver\",\"Name\":\" Driver 2  2\"},\"CreatedBy\":\"jignesh\"},\"AdvanceRequests\":{\"AdvanceRequest\":{\"BasicDetails\":{\"AdvanceNo\":\"SUIT-AR-2000016\",\"Date\":\"20201015120000\",\"BaseOffice\":{\"Code\":\"SUIT\",\"Name\":\"Iron Bird Jakarta\"},\"OfficeBaseCurrency\":\"IDR\",\"AdvanceAmount\":\"3057000.00000\",\"AdvanceCurrency\":\"IDR\",\"ExchangeRate\":\"1.00000\",\"AmountInBaseCurrency\":\"3057000.00000\",\"AmountSettled\":\"2720000.00000\",\"AssetDetails\":{\"AssetType\":[],\"AssetNo\":\"B9251UEV\"}},\"ChargeDetails\":{\"ChargeDetail\":[{\"JobNo\":\"SUIT-RL-2000038\",\"JobDate\":\"20201015041730\",\"ServiceType\":\"SEA\",\"ProcessType\":\"Local\",\"Charge\":{\"Code\":\"Kawlan\",\"AccountCode\":\"5001130020\",\"Description\":\"Kawlan\"},\"BasedOn\":\"Vehicle\",\"UOM\":[],\"Quantity\":\"1.00000\",\"Rate\":\"100000.00000\",\"Amount\":\"100000.00000\",\"VendorInvoiceNo\":\"SUIT-CINV-2000012\",\"VendorInvoiceDate\":\"20201015120000\"},{\"JobNo\":\"SUIT-RL-2000038\",\"JobDate\":\"20201015041730\",\"ServiceType\":\"SEA\",\"ProcessType\":\"Local\",\"Charge\":{\"Code\":\"DanaSolar\",\"AccountCode\":\"5001130020\",\"Description\":\"Dana Solar\"},\"BasedOn\":\"Vehicle\",\"UOM\":[],\"Quantity\":\"1.00000\",\"Rate\":\"1400000.00000\",\"Amount\":\"1400000.00000\",\"VendorInvoiceNo\":\"SUIT-CINV-2000012\",\"VendorInvoiceDate\":\"20201015120000\"},{\"JobNo\":\"SUIT-RL-2000038\",\"JobDate\":\"20201015041730\",\"ServiceType\":\"SEA\",\"ProcessType\":\"Local\",\"Charge\":{\"Code\":\"DpKomisi\",\"AccountCode\":\"5001130020\",\"Description\":\"Dp Komisi\"},\"BasedOn\":\"Vehicle\",\"UOM\":[],\"Quantity\":\"1.00000\",\"Rate\":\"500000.00000\",\"Amount\":\"500000.00000\",\"VendorInvoiceNo\":\"SUIT-CINV-2000012\",\"VendorInvoiceDate\":\"20201015120000\"},{\"JobNo\":\"SUIT-RL-2000038\",\"JobDate\":\"20201015041730\",\"ServiceType\":\"SEA\",\"ProcessType\":\"Local\",\"Charge\":{\"Code\":\"Parking\",\"AccountCode\":\"5001130020\",\"Description\":\"Parking Charges\"},\"BasedOn\":\"Vehicle\",\"UOM\":[],\"Quantity\":\"1.00000\",\"Rate\":\"150000.00000\",\"Amount\":\"150000.00000\",\"VendorInvoiceNo\":\"SUIT-CINV-2000012\",\"VendorInvoiceDate\":\"20201015120000\"},{\"JobNo\":\"SUIT-RL-2000038\",\"JobDate\":\"20201015041730\",\"ServiceType\":\"SEA\",\"ProcessType\":\"Local\",\"Charge\":{\"Code\":\"Toll\",\"AccountCode\":\"5001130020\",\"Description\":\"Toll Charges\"},\"BasedOn\":\"Vehicle\",\"UOM\":[],\"Quantity\":\"1.00000\",\"Rate\":\"495000.00000\",\"Amount\":\"495000.00000\",\"VendorInvoiceNo\":\"SUIT-CINV-2000012\",\"VendorInvoiceDate\":\"20201015120000\"},{\"JobNo\":\"SUIT-RL-2000038\",\"JobDate\":\"20201015041730\",\"ServiceType\":\"SEA\",\"ProcessType\":\"Local\",\"Charge\":{\"Code\":\"Bongkar\",\"AccountCode\":\"5001130020\",\"Description\":\"Bongkar Charges\"},\"BasedOn\":\"Vehicle\",\"UOM\":[],\"Quantity\":\"1.00000\",\"Rate\":\"75000.00000\",\"Amount\":\"75000.00000\",\"VendorInvoiceNo\":\"SUIT-CINV-2000012\",\"VendorInvoiceDate\":\"20201015120000\"}]},\"AdvancePostingDetails\":{\"AdvancePosting\":[{\"AccountPostingCode\":\"1101040001\",\"AccountType\":\"Cr\",\"AccountCurrency\":\"IDR\",\"AccountAmount\":\"337000.00000\"},{\"AccountPostingCode\":\"1101010001\",\"AccountType\":\"Dr\",\"AccountCurrency\":\"IDR\",\"AccountAmount\":\"337000.00000\"}]}}}}}}', '{\"Fitrxlgc\":{\"item\":[{\"LgcBelnr\":\"1\",\"LgcBuzei\":1,\"Bldat\":\"2020-10-15\",\"Blart\":\"ZL\",\"Budat\":\"2020-10-15\",\"Monat\":\"10\",\"Waers\":\"IDR\",\"Xblnr\":\"SUIT-SET-2000010\",\"Bktxt\":\"SUIT-AR-2000016\",\"Bukrs\":\"IBTO\",\"Hkont\":\"5001130020\",\"Wrbtr\":1000,\"Valut\":\"2020-10-15\",\"Prctr\":\"\",\"Kostl\":null,\"Zuonr\":\"SUIT-AR-2000016\",\"Sgtxt\":\"SUIT-RL-2000038\",\"Shkzg\":\"S\",\"Lifnr\":\"\",\"Kunnr\":\"\",\"RefLgcBelnr\":\"\",\"FiBelnr\":\"\",\"FiGjahr\":\"\",\"Umskz\":\"\",\"RefKey1\":\"40\"},{\"LgcBelnr\":\"1\",\"LgcBuzei\":2,\"Bldat\":\"2020-10-15\",\"Blart\":\"ZL\",\"Budat\":\"2020-10-15\",\"Monat\":\"10\",\"Waers\":\"IDR\",\"Xblnr\":\"SUIT-SET-2000010\",\"Bktxt\":\"SUIT-AR-2000016\",\"Bukrs\":\"IBTO\",\"Hkont\":\"5001130020\",\"Wrbtr\":14000,\"Valut\":\"2020-10-15\",\"Prctr\":\"\",\"Kostl\":null,\"Zuonr\":\"SUIT-AR-2000016\",\"Sgtxt\":\"SUIT-RL-2000038\",\"Shkzg\":\"S\",\"Lifnr\":\"\",\"Kunnr\":\"\",\"RefLgcBelnr\":\"\",\"FiBelnr\":\"\",\"FiGjahr\":\"\",\"Umskz\":\"\",\"RefKey1\":\"40\"},{\"LgcBelnr\":\"1\",\"LgcBuzei\":3,\"Bldat\":\"2020-10-15\",\"Blart\":\"ZL\",\"Budat\":\"2020-10-15\",\"Monat\":\"10\",\"Waers\":\"IDR\",\"Xblnr\":\"SUIT-SET-2000010\",\"Bktxt\":\"SUIT-AR-2000016\",\"Bukrs\":\"IBTO\",\"Hkont\":\"5001130020\",\"Wrbtr\":5000,\"Valut\":\"2020-10-15\",\"Prctr\":\"\",\"Kostl\":null,\"Zuonr\":\"SUIT-AR-2000016\",\"Sgtxt\":\"SUIT-RL-2000038\",\"Shkzg\":\"S\",\"Lifnr\":\"\",\"Kunnr\":\"\",\"RefLgcBelnr\":\"\",\"FiBelnr\":\"\",\"FiGjahr\":\"\",\"Umskz\":\"\",\"RefKey1\":\"40\"},{\"LgcBelnr\":\"1\",\"LgcBuzei\":4,\"Bldat\":\"2020-10-15\",\"Blart\":\"ZL\",\"Budat\":\"2020-10-15\",\"Monat\":\"10\",\"Waers\":\"IDR\",\"Xblnr\":\"SUIT-SET-2000010\",\"Bktxt\":\"SUIT-AR-2000016\",\"Bukrs\":\"IBTO\",\"Hkont\":\"5001130020\",\"Wrbtr\":1500,\"Valut\":\"2020-10-15\",\"Prctr\":\"\",\"Kostl\":null,\"Zuonr\":\"SUIT-AR-2000016\",\"Sgtxt\":\"SUIT-RL-2000038\",\"Shkzg\":\"S\",\"Lifnr\":\"\",\"Kunnr\":\"\",\"RefLgcBelnr\":\"\",\"FiBelnr\":\"\",\"FiGjahr\":\"\",\"Umskz\":\"\",\"RefKey1\":\"40\"},{\"LgcBelnr\":\"1\",\"LgcBuzei\":5,\"Bldat\":\"2020-10-15\",\"Blart\":\"ZL\",\"Budat\":\"2020-10-15\",\"Monat\":\"10\",\"Waers\":\"IDR\",\"Xblnr\":\"SUIT-SET-2000010\",\"Bktxt\":\"SUIT-AR-2000016\",\"Bukrs\":\"IBTO\",\"Hkont\":\"5001130020\",\"Wrbtr\":4950,\"Valut\":\"2020-10-15\",\"Prctr\":\"\",\"Kostl\":null,\"Zuonr\":\"SUIT-AR-2000016\",\"Sgtxt\":\"SUIT-RL-2000038\",\"Shkzg\":\"S\",\"Lifnr\":\"\",\"Kunnr\":\"\",\"RefLgcBelnr\":\"\",\"FiBelnr\":\"\",\"FiGjahr\":\"\",\"Umskz\":\"\",\"RefKey1\":\"40\"},{\"LgcBelnr\":\"1\",\"LgcBuzei\":6,\"Bldat\":\"2020-10-15\",\"Blart\":\"ZL\",\"Budat\":\"2020-10-15\",\"Monat\":\"10\",\"Waers\":\"IDR\",\"Xblnr\":\"SUIT-SET-2000010\",\"Bktxt\":\"SUIT-AR-2000016\",\"Bukrs\":\"IBTO\",\"Hkont\":\"5001130020\",\"Wrbtr\":750,\"Valut\":\"2020-10-15\",\"Prctr\":\"\",\"Kostl\":null,\"Zuonr\":\"SUIT-AR-2000016\",\"Sgtxt\":\"SUIT-RL-2000038\",\"Shkzg\":\"S\",\"Lifnr\":\"\",\"Kunnr\":\"\",\"RefLgcBelnr\":\"\",\"FiBelnr\":\"\",\"FiGjahr\":\"\",\"Umskz\":\"\",\"RefKey1\":\"40\"},{\"LgcBelnr\":\"1\",\"LgcBuzei\":7,\"Bldat\":\"2020-10-15\",\"Blart\":\"ZL\",\"Budat\":\"2020-10-15\",\"Monat\":\"10\",\"Waers\":\"IDR\",\"Xblnr\":\"SUIT-SET-2000010\",\"Bktxt\":\"SUIT-AR-2000016\",\"Bukrs\":\"IBTO\",\"Hkont\":\"1101040001\",\"Wrbtr\":27200,\"Valut\":\"2020-10-15\",\"Prctr\":\"\",\"Kostl\":\"\",\"Zuonr\":\"SUIT-AR-2000016\",\"Sgtxt\":null,\"Shkzg\":\"H\",\"Lifnr\":\"\",\"Kunnr\":\"\",\"RefLgcBelnr\":\"\",\"FiBelnr\":\"\",\"FiGjahr\":\"\",\"Umskz\":\"\",\"RefKey1\":\"50\"}]},\"Return\":{\"item\":[{\"Type\":\"\",\"Id\":\"\",\"Number\":\"\",\"Message\":\"\",\"LogNo\":\"\",\"LogMsgNo\":\"\",\"MessageV1\":\"\",\"MessageV2\":\"\",\"MessageV3\":\"\",\"MessageV4\":\"\",\"Parameter\":\"\",\"Row\":\"\",\"Field\":\"\",\"System\":\"\"},{\"Type\":\"\",\"Id\":\"\",\"Number\":\"\",\"Message\":\"\",\"LogNo\":\"\",\"LogMsgNo\":\"\",\"MessageV1\":\"\",\"MessageV2\":\"\",\"MessageV3\":\"\",\"MessageV4\":\"\",\"Parameter\":\"\",\"Row\":\"\",\"Field\":\"\",\"System\":\"\"},{\"Type\":\"\",\"Id\":\"\",\"Number\":\"\",\"Message\":\"\",\"LogNo\":\"\",\"LogMsgNo\":\"\",\"MessageV1\":\"\",\"MessageV2\":\"\",\"MessageV3\":\"\",\"MessageV4\":\"\",\"Parameter\":\"\",\"Row\":\"\",\"Field\":\"\",\"System\":\"\"},{\"Type\":\"\",\"Id\":\"\",\"Number\":\"\",\"Message\":\"\",\"LogNo\":\"\",\"LogMsgNo\":\"\",\"MessageV1\":\"\",\"MessageV2\":\"\",\"MessageV3\":\"\",\"MessageV4\":\"\",\"Parameter\":\"\",\"Row\":\"\",\"Field\":\"\",\"System\":\"\"},{\"Type\":\"\",\"Id\":\"\",\"Number\":\"\",\"Message\":\"\",\"LogNo\":\"\",\"LogMsgNo\":\"\",\"MessageV1\":\"\",\"MessageV2\":\"\",\"MessageV3\":\"\",\"MessageV4\":\"\",\"Parameter\":\"\",\"Row\":\"\",\"Field\":\"\",\"System\":\"\"},{\"Type\":\"\",\"Id\":\"\",\"Number\":\"\",\"Message\":\"\",\"LogNo\":\"\",\"LogMsgNo\":\"\",\"MessageV1\":\"\",\"MessageV2\":\"\",\"MessageV3\":\"\",\"MessageV4\":\"\",\"Parameter\":\"\",\"Row\":\"\",\"Field\":\"\",\"System\":\"\"},{\"Type\":\"\",\"Id\":\"\",\"Number\":\"\",\"Message\":\"\",\"LogNo\":\"\",\"LogMsgNo\":\"\",\"MessageV1\":\"\",\"MessageV2\":\"\",\"MessageV3\":\"\",\"MessageV4\":\"\",\"Parameter\":\"\",\"Row\":\"\",\"Field\":\"\",\"System\":\"\"}]},\"Test\":\"\"}'),
('5fa368cc9d204', 'SUIT-SET-2000010', '2020-11-05 09:56:30', 'settlement', 'SAP_FIPOST', 'SUIT-SET-2000010', '[\"Error in document: BKPFF 0000 S4DCLNT320\",\"Account 5001130020 requires an assignment to a CO object\",\"Account 5001130020 requires an assignment to a CO object\",\"Account 5001130020 requires an assignment to a CO object\",\"Account 5001130020 requires an assignment to a CO object\",\"Account 5001130020 requires an assignment to a CO object\",\"Account 5001130020 requires an assignment to a CO object\"]', '{\"Header\":{\"MessageType\":\"Settlement\",\"MessageVersion\":\"1\",\"MessageIdentifier\":\"c679e2ce-9361-4afa-87c4-082f85ebdec0\",\"MessageDateTime\":\"20201022052004\",\"Partners\":{\"PartnerInformation\":{\"ContactInformation\":[]}}},\"SettlementDetail\":{\"Settlement\":{\"BasicDetails\":{\"SettlementNo\":\"SUIT-SET-2000010\",\"Date\":\"20201015000000\",\"BaseOffice\":{\"Code\":\"SUIT\",\"Name\":\"Iron Bird Jakarta\"},\"OfficeBaseCurrency\":\"IDR\",\"VendorDetails\":{\"Code\":\"Driver\",\"Name\":\"Driver (Own Transport)\",\"Address1\":\"-\",\"Country\":[]},\"ResourceDetails\":{\"ResourceFunction\":\"Driver\",\"Code\":\"Driver\",\"Name\":\" Driver 2  2\"},\"CreatedBy\":\"jignesh\"},\"AdvanceRequests\":{\"AdvanceRequest\":{\"BasicDetails\":{\"AdvanceNo\":\"SUIT-AR-2000016\",\"Date\":\"20201015120000\",\"BaseOffice\":{\"Code\":\"SUIT\",\"Name\":\"Iron Bird Jakarta\"},\"OfficeBaseCurrency\":\"IDR\",\"AdvanceAmount\":\"3057000.00000\",\"AdvanceCurrency\":\"IDR\",\"ExchangeRate\":\"1.00000\",\"AmountInBaseCurrency\":\"3057000.00000\",\"AmountSettled\":\"2720000.00000\",\"AssetDetails\":{\"AssetType\":[],\"AssetNo\":\"B9251UEV\"}},\"ChargeDetails\":{\"ChargeDetail\":[{\"JobNo\":\"SUIT-RL-2000038\",\"JobDate\":\"20201015041730\",\"ServiceType\":\"SEA\",\"ProcessType\":\"Local\",\"Charge\":{\"Code\":\"Kawlan\",\"AccountCode\":\"5001130020\",\"Description\":\"Kawlan\"},\"BasedOn\":\"Vehicle\",\"UOM\":[],\"Quantity\":\"1.00000\",\"Rate\":\"100000.00000\",\"Amount\":\"100000.00000\",\"VendorInvoiceNo\":\"SUIT-CINV-2000012\",\"VendorInvoiceDate\":\"20201015120000\"},{\"JobNo\":\"SUIT-RL-2000038\",\"JobDate\":\"20201015041730\",\"ServiceType\":\"SEA\",\"ProcessType\":\"Local\",\"Charge\":{\"Code\":\"DanaSolar\",\"AccountCode\":\"5001130020\",\"Description\":\"Dana Solar\"},\"BasedOn\":\"Vehicle\",\"UOM\":[],\"Quantity\":\"1.00000\",\"Rate\":\"1400000.00000\",\"Amount\":\"1400000.00000\",\"VendorInvoiceNo\":\"SUIT-CINV-2000012\",\"VendorInvoiceDate\":\"20201015120000\"},{\"JobNo\":\"SUIT-RL-2000038\",\"JobDate\":\"20201015041730\",\"ServiceType\":\"SEA\",\"ProcessType\":\"Local\",\"Charge\":{\"Code\":\"DpKomisi\",\"AccountCode\":\"5001130020\",\"Description\":\"Dp Komisi\"},\"BasedOn\":\"Vehicle\",\"UOM\":[],\"Quantity\":\"1.00000\",\"Rate\":\"500000.00000\",\"Amount\":\"500000.00000\",\"VendorInvoiceNo\":\"SUIT-CINV-2000012\",\"VendorInvoiceDate\":\"20201015120000\"},{\"JobNo\":\"SUIT-RL-2000038\",\"JobDate\":\"20201015041730\",\"ServiceType\":\"SEA\",\"ProcessType\":\"Local\",\"Charge\":{\"Code\":\"Parking\",\"AccountCode\":\"5001130020\",\"Description\":\"Parking Charges\"},\"BasedOn\":\"Vehicle\",\"UOM\":[],\"Quantity\":\"1.00000\",\"Rate\":\"150000.00000\",\"Amount\":\"150000.00000\",\"VendorInvoiceNo\":\"SUIT-CINV-2000012\",\"VendorInvoiceDate\":\"20201015120000\"},{\"JobNo\":\"SUIT-RL-2000038\",\"JobDate\":\"20201015041730\",\"ServiceType\":\"SEA\",\"ProcessType\":\"Local\",\"Charge\":{\"Code\":\"Toll\",\"AccountCode\":\"5001130020\",\"Description\":\"Toll Charges\"},\"BasedOn\":\"Vehicle\",\"UOM\":[],\"Quantity\":\"1.00000\",\"Rate\":\"495000.00000\",\"Amount\":\"495000.00000\",\"VendorInvoiceNo\":\"SUIT-CINV-2000012\",\"VendorInvoiceDate\":\"20201015120000\"},{\"JobNo\":\"SUIT-RL-2000038\",\"JobDate\":\"20201015041730\",\"ServiceType\":\"SEA\",\"ProcessType\":\"Local\",\"Charge\":{\"Code\":\"Bongkar\",\"AccountCode\":\"5001130020\",\"Description\":\"Bongkar Charges\"},\"BasedOn\":\"Vehicle\",\"UOM\":[],\"Quantity\":\"1.00000\",\"Rate\":\"75000.00000\",\"Amount\":\"75000.00000\",\"VendorInvoiceNo\":\"SUIT-CINV-2000012\",\"VendorInvoiceDate\":\"20201015120000\"}]},\"AdvancePostingDetails\":{\"AdvancePosting\":[{\"AccountPostingCode\":\"1101040001\",\"AccountType\":\"Cr\",\"AccountCurrency\":\"IDR\",\"AccountAmount\":\"337000.00000\"},{\"AccountPostingCode\":\"1101010001\",\"AccountType\":\"Dr\",\"AccountCurrency\":\"IDR\",\"AccountAmount\":\"337000.00000\"}]}}}}}}', '{\"Fitrxlgc\":{\"item\":[{\"LgcBelnr\":\"1\",\"LgcBuzei\":1,\"Bldat\":\"2020-10-15\",\"Blart\":\"ZL\",\"Budat\":\"2020-10-15\",\"Monat\":\"10\",\"Waers\":\"IDR\",\"Xblnr\":\"SUIT-SET-2000010\",\"Bktxt\":\"SUIT-AR-2000016\",\"Bukrs\":\"IBTO\",\"Hkont\":\"5001130020\",\"Wrbtr\":1000,\"Valut\":\"2020-10-15\",\"Prctr\":\"\",\"Kostl\":null,\"Zuonr\":\"SUIT-AR-2000016\",\"Sgtxt\":\"SUIT-RL-2000038\",\"Shkzg\":\"S\",\"Lifnr\":\"\",\"Kunnr\":\"\",\"RefLgcBelnr\":\"\",\"FiBelnr\":\"\",\"FiGjahr\":\"\",\"Umskz\":\"\",\"RefKey1\":\"40\"},{\"LgcBelnr\":\"1\",\"LgcBuzei\":2,\"Bldat\":\"2020-10-15\",\"Blart\":\"ZL\",\"Budat\":\"2020-10-15\",\"Monat\":\"10\",\"Waers\":\"IDR\",\"Xblnr\":\"SUIT-SET-2000010\",\"Bktxt\":\"SUIT-AR-2000016\",\"Bukrs\":\"IBTO\",\"Hkont\":\"5001130020\",\"Wrbtr\":14000,\"Valut\":\"2020-10-15\",\"Prctr\":\"\",\"Kostl\":null,\"Zuonr\":\"SUIT-AR-2000016\",\"Sgtxt\":\"SUIT-RL-2000038\",\"Shkzg\":\"S\",\"Lifnr\":\"\",\"Kunnr\":\"\",\"RefLgcBelnr\":\"\",\"FiBelnr\":\"\",\"FiGjahr\":\"\",\"Umskz\":\"\",\"RefKey1\":\"40\"},{\"LgcBelnr\":\"1\",\"LgcBuzei\":3,\"Bldat\":\"2020-10-15\",\"Blart\":\"ZL\",\"Budat\":\"2020-10-15\",\"Monat\":\"10\",\"Waers\":\"IDR\",\"Xblnr\":\"SUIT-SET-2000010\",\"Bktxt\":\"SUIT-AR-2000016\",\"Bukrs\":\"IBTO\",\"Hkont\":\"5001130020\",\"Wrbtr\":5000,\"Valut\":\"2020-10-15\",\"Prctr\":\"\",\"Kostl\":null,\"Zuonr\":\"SUIT-AR-2000016\",\"Sgtxt\":\"SUIT-RL-2000038\",\"Shkzg\":\"S\",\"Lifnr\":\"\",\"Kunnr\":\"\",\"RefLgcBelnr\":\"\",\"FiBelnr\":\"\",\"FiGjahr\":\"\",\"Umskz\":\"\",\"RefKey1\":\"40\"},{\"LgcBelnr\":\"1\",\"LgcBuzei\":4,\"Bldat\":\"2020-10-15\",\"Blart\":\"ZL\",\"Budat\":\"2020-10-15\",\"Monat\":\"10\",\"Waers\":\"IDR\",\"Xblnr\":\"SUIT-SET-2000010\",\"Bktxt\":\"SUIT-AR-2000016\",\"Bukrs\":\"IBTO\",\"Hkont\":\"5001130020\",\"Wrbtr\":1500,\"Valut\":\"2020-10-15\",\"Prctr\":\"\",\"Kostl\":null,\"Zuonr\":\"SUIT-AR-2000016\",\"Sgtxt\":\"SUIT-RL-2000038\",\"Shkzg\":\"S\",\"Lifnr\":\"\",\"Kunnr\":\"\",\"RefLgcBelnr\":\"\",\"FiBelnr\":\"\",\"FiGjahr\":\"\",\"Umskz\":\"\",\"RefKey1\":\"40\"},{\"LgcBelnr\":\"1\",\"LgcBuzei\":5,\"Bldat\":\"2020-10-15\",\"Blart\":\"ZL\",\"Budat\":\"2020-10-15\",\"Monat\":\"10\",\"Waers\":\"IDR\",\"Xblnr\":\"SUIT-SET-2000010\",\"Bktxt\":\"SUIT-AR-2000016\",\"Bukrs\":\"IBTO\",\"Hkont\":\"5001130020\",\"Wrbtr\":4950,\"Valut\":\"2020-10-15\",\"Prctr\":\"\",\"Kostl\":null,\"Zuonr\":\"SUIT-AR-2000016\",\"Sgtxt\":\"SUIT-RL-2000038\",\"Shkzg\":\"S\",\"Lifnr\":\"\",\"Kunnr\":\"\",\"RefLgcBelnr\":\"\",\"FiBelnr\":\"\",\"FiGjahr\":\"\",\"Umskz\":\"\",\"RefKey1\":\"40\"},{\"LgcBelnr\":\"1\",\"LgcBuzei\":6,\"Bldat\":\"2020-10-15\",\"Blart\":\"ZL\",\"Budat\":\"2020-10-15\",\"Monat\":\"10\",\"Waers\":\"IDR\",\"Xblnr\":\"SUIT-SET-2000010\",\"Bktxt\":\"SUIT-AR-2000016\",\"Bukrs\":\"IBTO\",\"Hkont\":\"5001130020\",\"Wrbtr\":750,\"Valut\":\"2020-10-15\",\"Prctr\":\"\",\"Kostl\":null,\"Zuonr\":\"SUIT-AR-2000016\",\"Sgtxt\":\"SUIT-RL-2000038\",\"Shkzg\":\"S\",\"Lifnr\":\"\",\"Kunnr\":\"\",\"RefLgcBelnr\":\"\",\"FiBelnr\":\"\",\"FiGjahr\":\"\",\"Umskz\":\"\",\"RefKey1\":\"40\"},{\"LgcBelnr\":\"1\",\"LgcBuzei\":7,\"Bldat\":\"2020-10-15\",\"Blart\":\"ZL\",\"Budat\":\"2020-10-15\",\"Monat\":\"10\",\"Waers\":\"IDR\",\"Xblnr\":\"SUIT-SET-2000010\",\"Bktxt\":\"SUIT-AR-2000016\",\"Bukrs\":\"IBTO\",\"Hkont\":\"1101040001\",\"Wrbtr\":27200,\"Valut\":\"2020-10-15\",\"Prctr\":\"\",\"Kostl\":\"\",\"Zuonr\":\"SUIT-AR-2000016\",\"Sgtxt\":null,\"Shkzg\":\"H\",\"Lifnr\":\"\",\"Kunnr\":\"\",\"RefLgcBelnr\":\"\",\"FiBelnr\":\"\",\"FiGjahr\":\"\",\"Umskz\":\"\",\"RefKey1\":\"50\"}]},\"Return\":{\"item\":[{\"Type\":\"\",\"Id\":\"\",\"Number\":\"\",\"Message\":\"\",\"LogNo\":\"\",\"LogMsgNo\":\"\",\"MessageV1\":\"\",\"MessageV2\":\"\",\"MessageV3\":\"\",\"MessageV4\":\"\",\"Parameter\":\"\",\"Row\":\"\",\"Field\":\"\",\"System\":\"\"},{\"Type\":\"\",\"Id\":\"\",\"Number\":\"\",\"Message\":\"\",\"LogNo\":\"\",\"LogMsgNo\":\"\",\"MessageV1\":\"\",\"MessageV2\":\"\",\"MessageV3\":\"\",\"MessageV4\":\"\",\"Parameter\":\"\",\"Row\":\"\",\"Field\":\"\",\"System\":\"\"},{\"Type\":\"\",\"Id\":\"\",\"Number\":\"\",\"Message\":\"\",\"LogNo\":\"\",\"LogMsgNo\":\"\",\"MessageV1\":\"\",\"MessageV2\":\"\",\"MessageV3\":\"\",\"MessageV4\":\"\",\"Parameter\":\"\",\"Row\":\"\",\"Field\":\"\",\"System\":\"\"},{\"Type\":\"\",\"Id\":\"\",\"Number\":\"\",\"Message\":\"\",\"LogNo\":\"\",\"LogMsgNo\":\"\",\"MessageV1\":\"\",\"MessageV2\":\"\",\"MessageV3\":\"\",\"MessageV4\":\"\",\"Parameter\":\"\",\"Row\":\"\",\"Field\":\"\",\"System\":\"\"},{\"Type\":\"\",\"Id\":\"\",\"Number\":\"\",\"Message\":\"\",\"LogNo\":\"\",\"LogMsgNo\":\"\",\"MessageV1\":\"\",\"MessageV2\":\"\",\"MessageV3\":\"\",\"MessageV4\":\"\",\"Parameter\":\"\",\"Row\":\"\",\"Field\":\"\",\"System\":\"\"},{\"Type\":\"\",\"Id\":\"\",\"Number\":\"\",\"Message\":\"\",\"LogNo\":\"\",\"LogMsgNo\":\"\",\"MessageV1\":\"\",\"MessageV2\":\"\",\"MessageV3\":\"\",\"MessageV4\":\"\",\"Parameter\":\"\",\"Row\":\"\",\"Field\":\"\",\"System\":\"\"},{\"Type\":\"\",\"Id\":\"\",\"Number\":\"\",\"Message\":\"\",\"LogNo\":\"\",\"LogMsgNo\":\"\",\"MessageV1\":\"\",\"MessageV2\":\"\",\"MessageV3\":\"\",\"MessageV4\":\"\",\"Parameter\":\"\",\"Row\":\"\",\"Field\":\"\",\"System\":\"\"}]},\"Test\":\"\"}'),
('5fa3fb1ede237', '0960000004', '2020-11-05 20:16:14', 'customer', 'SCM_BPPOST', '0960000004', 'GenericKey_OfficeDoesNotExists', '{\"ResponseDetail\":{\"ResponseType\":\"Response\",\"ResponseLevel\":\"Details\",\"RefId\":\"0960000004\",\"Status\":\"Fail\",\"ErrorCode\":\"0002\",\"ErrorDescription\":\"GenericKey_OfficeDoesNotExists\"}}', '{\"DateFr\":\"2020-01-01\",\"DateTo\":\"2020-11-05\",\"YfiCustomer\":{\"item\":{\"Kunnr\":\"\"}}}'),
('5fa3fd2fb0514', '0960000004', '2020-11-09 12:38:53', 'customer', 'SCM_BPPOST', '0960000004', 'GenericKey_OfficeDoesNotExists', '{\"ResponseDetail\":{\"ResponseType\":\"Response\",\"ResponseLevel\":\"Details\",\"RefId\":\"0960000004\",\"Status\":\"Fail\",\"ErrorCode\":\"0002\",\"ErrorDescription\":\"GenericKey_OfficeDoesNotExists\"}}', '{\"DateFr\":\"2020-01-01\",\"DateTo\":\"2020-11-05\",\"YfiCustomer\":{\"item\":{\"Kunnr\":\"\"}}}'),
('5fa3fe0fb1557', '2020010120201105', '2020-11-05 20:31:22', 'vendor', 'SCM_BPPOST', '2020010120201105', 'GenericKey_OfficeDoesNotExists', '{\"ResponseDetail\":{\"ResponseType\":\"Response\",\"ResponseLevel\":\"Details\",\"RefId\":\"0800000103\",\"Status\":\"Fail\",\"ErrorCode\":\"0002\",\"ErrorDescription\":\"GenericKey_OfficeDoesNotExists\"}}', '{\"DateFr\":\"2020-01-01\",\"DateTo\":\"2020-11-05\",\"YfiVendor\":{\"item\":{\"Lifnr\":\"\"}}}'),
('5fa8a772bb4eb', 'CKIB-AR-2000054', '2020-11-09 09:20:34', 'advance', 'SAP_FIPOST', 'CKIB-AR-2000054', '[\"Error in document: BKPFF 0000 S4DCLNT320\",\"G\\/L account 5101010001 is not defined in chart of accounts IBCA\",\"G\\/L account 5101010001 is not defined in chart of accounts IBCA\"]', '{\"Header\":{\"MessageType\":\"AdvReq\",\"MessageVersion\":\"1\",\"MessageIdentifier\":\"0866e51c-682e-4aa9-a08a-23f5333f75c0\",\"MessageDateTime\":\"20201107085000\",\"Partners\":{\"PartnerInformation\":{\"ContactInformation\":[]}}},\"AdvanceRequest\":{\"AdvanceRequestDetails\":{\"BasicDetails\":{\"AdvanceNo\":\"CKIB-AR-2000054\",\"Date\":\"20201107120000\",\"BaseOffice\":{\"Code\":\"CKIB\",\"Name\":\"Iron Bird Jakarta\"},\"OfficeBaseCurrency\":\"IDR\",\"AdvanceAmount\":\"3057000.00000\",\"AdvanceCurrency\":\"IDR\",\"ExchangeRate\":\"1.00000\",\"AmountinBaseCurrency\":\"IDR\",\"VendorDetails\":{\"Code\":\"Driver\",\"Name\":\"Driver (Own Transport)\",\"Address1\":\"-\",\"Country\":[]},\"ResourceDetails\":{\"ResourceFunction\":\"Driver\",\"Code\":\"Driver\",\"Name\":\" Jignesh  Adeshara\"},\"AssetDetails\":{\"AssetType\":[],\"AssetNo\":\"B9842UEV\"},\"Status\":\"Finalized\",\"FinalizationDate\":\"20201107085000\",\"ReversalDate\":[],\"ReversalRemarks\":[]},\"ChargeDetails\":{\"ChargeDetail\":[{\"JobNo\":\"CKIB-RL-2000112\",\"JobDate\":\"20201107084619\",\"ServiceType\":\"Local\",\"Charge\":{\"Code\":\"Parking\",\"Description\":\"Parking Charges\"},\"BasedOn\":\"Vehicle\",\"UOM\":[],\"Quantity\":\"1.00000\",\"Rate\":\"150000.00000\",\"Amount\":\"150000.00000\"},{\"JobNo\":\"CKIB-RL-2000112\",\"JobDate\":\"20201107084619\",\"ServiceType\":\"Local\",\"Charge\":{\"Code\":\"DanaSolar\",\"Description\":\"Dana Solar\"},\"BasedOn\":\"Vehicle\",\"UOM\":[],\"Quantity\":\"1.00000\",\"Rate\":\"1637000.00000\",\"Amount\":\"1637000.00000\"},{\"JobNo\":\"CKIB-RL-2000112\",\"JobDate\":\"20201107084619\",\"ServiceType\":\"Local\",\"Charge\":{\"Code\":\"DpKomisi\",\"Description\":\"Dp Komisi\"},\"BasedOn\":\"Vehicle\",\"UOM\":[],\"Quantity\":\"1.00000\",\"Rate\":\"500000.00000\",\"Amount\":\"500000.00000\"},{\"JobNo\":\"CKIB-RL-2000112\",\"JobDate\":\"20201107084619\",\"ServiceType\":\"Local\",\"Charge\":{\"Code\":\"Toll\",\"Description\":\"Toll Charges\"},\"BasedOn\":\"Vehicle\",\"UOM\":[],\"Quantity\":\"1.00000\",\"Rate\":\"595000.00000\",\"Amount\":\"595000.00000\"},{\"JobNo\":\"CKIB-RL-2000112\",\"JobDate\":\"20201107084619\",\"ServiceType\":\"Local\",\"Charge\":{\"Code\":\"Kawlan\",\"Description\":\"Kawlan\"},\"BasedOn\":\"Vehicle\",\"UOM\":[],\"Quantity\":\"1.00000\",\"Rate\":\"100000.00000\",\"Amount\":\"100000.00000\"},{\"JobNo\":\"CKIB-RL-2000112\",\"JobDate\":\"20201107084619\",\"ServiceType\":\"Local\",\"Charge\":{\"Code\":\"Bongkar\",\"Description\":\"Bongkar Charges\"},\"BasedOn\":\"Vehicle\",\"UOM\":[],\"Quantity\":\"1.00000\",\"Rate\":\"75000.00000\",\"Amount\":\"75000.00000\"}]},\"AdvancePostingDetails\":{\"AdvancePosting\":[{\"AccountPostingCode\":\"1101040001\",\"AccountType\":\"Dr\",\"AccountCurrency\":\"IDR\",\"AccountAmount\":\"3057000.00000\"},{\"AccountPostingCode\":\"5101010001\",\"AccountType\":\"Cr\",\"AccountCurrency\":\"IDR\",\"AccountAmount\":\"3057000.00000\"}]}}}}', '{\"Fitrxlgc\":{\"item\":[{\"LgcBelnr\":\"1\",\"LgcBuzei\":1,\"Bldat\":\"2020-11-07\",\"Blart\":\"ZT\",\"Budat\":\"2020-11-07\",\"Monat\":\"11\",\"Waers\":\"IDR\",\"Xblnr\":\"CKIB-AR-2000054\",\"Bktxt\":\"CKIB-AR-2000054\",\"Bukrs\":\"IRBO\",\"Hkont\":\"1101040001\",\"Wrbtr\":30570,\"Valut\":\"2020-11-07\",\"Prctr\":\"\",\"Kostl\":\"\",\"Zuonr\":\"CKIB-AR-2000054\",\"Sgtxt\":\"CKIB-AR-2000054\",\"Shkzg\":\"S\",\"Lifnr\":\"\",\"Kunnr\":\"\",\"RefLgcBelnr\":\"\",\"FiBelnr\":\"\",\"FiGjahr\":\"\",\"Umskz\":\"\",\"RefKey1\":40},{\"LgcBelnr\":\"1\",\"LgcBuzei\":2,\"Bldat\":\"2020-11-07\",\"Blart\":\"ZT\",\"Budat\":\"2020-11-07\",\"Monat\":\"11\",\"Waers\":\"IDR\",\"Xblnr\":\"CKIB-AR-2000054\",\"Bktxt\":\"CKIB-AR-2000054\",\"Bukrs\":\"IRBO\",\"Hkont\":\"5101010001\",\"Wrbtr\":30570,\"Valut\":\"2020-11-07\",\"Prctr\":\"\",\"Kostl\":\"\",\"Zuonr\":\"CKIB-AR-2000054\",\"Sgtxt\":\"CKIB-AR-2000054\",\"Shkzg\":\"H\",\"Lifnr\":\"\",\"Kunnr\":\"\",\"RefLgcBelnr\":\"\",\"FiBelnr\":\"\",\"FiGjahr\":\"\",\"Umskz\":\"\",\"RefKey1\":50}]},\"Return\":{\"item\":[{\"Type\":\"\",\"Id\":\"\",\"Number\":\"\",\"Message\":\"\",\"LogNo\":\"\",\"LogMsgNo\":\"\",\"MessageV1\":\"\",\"MessageV2\":\"\",\"MessageV3\":\"\",\"MessageV4\":\"\",\"Parameter\":\"\",\"Row\":\"\",\"Field\":\"\",\"System\":\"\"},{\"Type\":\"\",\"Id\":\"\",\"Number\":\"\",\"Message\":\"\",\"LogNo\":\"\",\"LogMsgNo\":\"\",\"MessageV1\":\"\",\"MessageV2\":\"\",\"MessageV3\":\"\",\"MessageV4\":\"\",\"Parameter\":\"\",\"Row\":\"\",\"Field\":\"\",\"System\":\"\"}]},\"Test\":\"\"}');

-- --------------------------------------------------------

--
-- Table structure for table `tb_invoice`
--

CREATE TABLE `tb_invoice` (
  `id` varchar(15) NOT NULL,
  `code` varchar(20) NOT NULL,
  `sap_reference` varchar(15) NOT NULL,
  `inv_date` date DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `office_code` varchar(10) DEFAULT NULL,
  `debtor_code` varchar(15) NOT NULL,
  `debtor_name` varchar(150) NOT NULL,
  `booking_code` varchar(30) NOT NULL,
  `job_number` varchar(20) NOT NULL,
  `job_date` date NOT NULL,
  `job_type` varchar(10) NOT NULL,
  `job_ref` varchar(50) NOT NULL,
  `pay_term` int(3) NOT NULL,
  `currency` varchar(4) NOT NULL,
  `amount` decimal(18,2) NOT NULL,
  `tax_amount` decimal(15,2) NOT NULL,
  `total_amount` decimal(18,2) NOT NULL,
  `receipt_code` varchar(30) NOT NULL,
  `receipt_flag` int(1) NOT NULL,
  `created` datetime NOT NULL,
  `created_by` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_invoice`
--

INSERT INTO `tb_invoice` (`id`, `code`, `sap_reference`, `inv_date`, `due_date`, `office_code`, `debtor_code`, `debtor_name`, `booking_code`, `job_number`, `job_date`, `job_type`, `job_ref`, `pay_term`, `currency`, `amount`, `tax_amount`, `total_amount`, `receipt_code`, `receipt_flag`, `created`, `created_by`) VALUES
('5f9a876242ec8', 'IBJKT-IN-2071248', '', '2020-07-24', '2020-08-07', 'SYIT', '0960000040', 'Debtor 001', '', 'IBJKT-RE-2000420', '2020-07-08', 'SEA', 'Rem 1678', 14, 'IDR', '575000.00', '57500.00', '632500.00', '', 0, '2020-10-29 16:12:02', 'sddodpostar'),
('5f9a8c335cffa', 'IBJKT-IN-2071249', '', '2020-07-24', '2020-08-07', 'SYIT', '0960000040', 'Debtor 001', '', 'IBJKT-RE-2000420', '2020-07-08', 'SEA', 'Rem 1678', 14, 'IDR', '575000.00', '57500.00', '632500.00', '', 0, '2020-10-29 16:32:35', 'sddodpostar'),
('5f9fcd35e750b', 'IBJKT-IN-2071240', '9300000085', '2020-07-24', '2020-08-07', 'SYIT', '0960000040', 'Debtor 001', 'IBJKT-BKG-2044105', 'IBJKT-RE-2000420', '2020-07-08', 'SEA', 'Rem 1678', 14, 'IDR', '575000.00', '57500.00', '632500.00', '', 1, '2020-11-02 16:11:17', 'sddodpostar'),
('5f9fcd8018f5b', 'IBJKT-IN-2071241', '9300000086', '2020-07-24', '2020-08-07', 'SYIT', '0960000040', 'Debtor 001', 'IBJKT-BKG-2044105', 'IBJKT-RE-2000420', '2020-07-08', 'SEA', 'Rem 1678', 14, 'IDR', '575000.00', '57500.00', '632500.00', 'SYIT-200000002', 1, '2020-11-02 16:12:32', 'sddodpostar'),
('5f9fcd9d2abaf', 'IBJKT-IN-2071243', '9300000087', '2020-07-24', '2020-08-07', 'SYIT', '0960000040', 'Debtor 001', 'IBJKT-BKG-2044105', 'IBJKT-RE-2000420', '2020-07-08', 'SEA', 'Rem 1678', 14, 'IDR', '575000.00', '57500.00', '632500.00', 'SYIT-200000002', 1, '2020-11-02 16:13:01', 'sddodpostar'),
('5fa4006463839', 'IBJKT-IN-2071268', '', '2020-07-24', '2020-08-07', 'SYIT', '0960000040', 'Debtor 001', '', 'IBJKT-RE-2000420', '2020-07-08', 'SEA', 'Rem 1678', 14, 'IDR', '575000.00', '57500.00', '632500.00', '', 0, '2020-11-05 20:38:44', 'sddodpostar');

-- --------------------------------------------------------

--
-- Table structure for table `tb_map_config`
--

CREATE TABLE `tb_map_config` (
  `id` int(11) NOT NULL,
  `type` char(2) NOT NULL,
  `office_code` char(1) DEFAULT NULL,
  `service_code` char(1) DEFAULT NULL,
  `material_code` char(1) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `modified_by` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_map_config`
--

INSERT INTO `tb_map_config` (`id`, `type`, `office_code`, `service_code`, `material_code`, `created`, `created_by`, `modified`, `modified_by`) VALUES
(1, 'CC', '1', '1', NULL, NULL, NULL, '2020-10-01 14:44:00', 'slamet'),
(2, 'PC', '1', '1', '1', '2020-10-01 15:00:03', 'slamet', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_map_ledger`
--

CREATE TABLE `tb_map_ledger` (
  `code` varchar(30) NOT NULL,
  `name` varchar(150) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_map_ledger`
--

INSERT INTO `tb_map_ledger` (`code`, `name`, `created`, `created_by`) VALUES
('1101010001', 'CASH OPS SEA', '2020-10-01 16:13:33', 'slamet'),
('1101040001', 'ADVANCE OPS SEA', '2020-10-01 16:12:45', 'slamet');

-- --------------------------------------------------------

--
-- Table structure for table `tb_map_material`
--

CREATE TABLE `tb_map_material` (
  `code` varchar(30) NOT NULL,
  `name` varchar(150) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_map_material`
--

INSERT INTO `tb_map_material` (`code`, `name`, `created`, `created_by`) VALUES
('BOX', 'BOX', '2020-11-03 06:48:49', NULL),
('L-00000553', 'OTHERS CHARGES (W)', NULL, NULL),
('L-00000555', 'TRANSPORTATION CDD (W)', NULL, NULL),
('L-00000591', 'CROSS DOCKING (W)', '2020-10-01 11:19:32', 'slamet'),
('TRAILER', 'TRAILER', '2020-11-03 06:49:14', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_map_office`
--

CREATE TABLE `tb_map_office` (
  `id` int(11) NOT NULL,
  `code` varchar(10) DEFAULT NULL,
  `name` varchar(50) NOT NULL,
  `entity` varchar(10) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_map_office`
--

INSERT INTO `tb_map_office` (`id`, `code`, `name`, `entity`, `created`, `created_by`) VALUES
(1, 'CKIB', 'IB Cakung', 'IRBO', '2020-09-25 17:49:17', 'slamet'),
(2, 'SUIB', 'IB Surabaya', 'IRBO', '2020-09-25 18:10:30', 'slamet'),
(3, 'SUIT', 'IBT Surabaya', 'IBTO', '2020-09-25 21:40:55', 'slamet'),
(5, 'CNIB', 'IB Cilegon', 'IRBO', '2020-09-29 17:41:15', 'slamet'),
(6, 'SGIB', 'IB Semarang', 'IRBO', '2020-09-29 17:41:30', 'slamet'),
(7, 'SGIT', 'IBT Semarang', 'IBTO', '2020-09-29 17:41:41', 'slamet'),
(8, 'SYIT', 'IBT JAKARTA', 'IBTO', '2020-10-01 11:05:09', 'slamet'),
(10, 'CIIT', 'Cilegon IBT', 'IBTO', '2020-11-03 06:40:37', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_map_pc`
--

CREATE TABLE `tb_map_pc` (
  `id` int(11) NOT NULL,
  `office_code` varchar(30) DEFAULT NULL,
  `service_code` varchar(30) DEFAULT NULL,
  `material_code` varchar(150) DEFAULT NULL,
  `profit_cost` varchar(150) DEFAULT NULL,
  `type` char(2) NOT NULL,
  `created` datetime DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `modified` datetime NOT NULL,
  `modified_by` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_map_pc`
--

INSERT INTO `tb_map_pc` (`id`, `office_code`, `service_code`, `material_code`, `profit_cost`, `type`, `created`, `created_by`, `modified`, `modified_by`) VALUES
(1, 'SUIT', 'AIR', NULL, 'PSHIT00F05', 'CC', '2020-10-01 10:57:07', 'slamet', '2020-11-03 07:40:56', ''),
(2, 'SYIT', 'AIR', NULL, 'PSHIT00F', 'PC', '2020-10-01 15:13:55', 'slamet', '2020-11-03 08:22:12', ''),
(28, 'CKIB', NULL, 'TRAILER', 'PSHIT00F05', 'CC', '2020-11-03 06:15:37', NULL, '2020-11-03 07:36:06', ''),
(29, 'CKIB', NULL, 'BOX', 'PSUB01010', 'CC', '2020-11-03 06:16:18', NULL, '2020-11-03 07:37:49', ''),
(31, 'CKIB', NULL, 'TRAILER', 'PSHIT00F', 'PC', '2020-11-03 08:02:40', NULL, '2020-11-03 08:21:29', '');

-- --------------------------------------------------------

--
-- Table structure for table `tb_map_posted_cm`
--

CREATE TABLE `tb_map_posted_cm` (
  `id` int(11) NOT NULL,
  `office_code` varchar(30) DEFAULT NULL,
  `service_code` varchar(30) DEFAULT NULL,
  `advance_db` char(10) DEFAULT NULL,
  `advance_cr` char(10) DEFAULT NULL,
  `settlement_cr` char(10) NOT NULL,
  `created` datetime DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `modified` datetime NOT NULL,
  `modified_by` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_map_posted_cm`
--

INSERT INTO `tb_map_posted_cm` (`id`, `office_code`, `service_code`, `advance_db`, `advance_cr`, `settlement_cr`, `created`, `created_by`, `modified`, `modified_by`) VALUES
(1, 'SYIT', 'SEA', '1101040001', '1101010001', '1101040001', '2020-10-01 16:18:30', 'slamet', '0000-00-00 00:00:00', '');

-- --------------------------------------------------------

--
-- Table structure for table `tb_map_profitcost`
--

CREATE TABLE `tb_map_profitcost` (
  `code` varchar(20) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `type` varchar(2) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_map_profitcost`
--

INSERT INTO `tb_map_profitcost` (`code`, `name`, `type`, `created`, `created_by`) VALUES
('PSHIT00F', 'IBT JAKARTA', 'PC', '2020-10-01 15:07:24', 'slamet'),
('PSHIT00F05', 'Opt. Air Cargo', 'CC', NULL, NULL),
('PSHIT00F06', 'OPS.WH', NULL, '2020-10-01 12:39:11', 'slamet'),
('PSUB010', 'CILEGON IBT', 'PC', '2020-11-03 07:57:30', NULL),
('PSUB01010', 'E', 'CC', '2020-11-03 06:52:23', NULL),
('PSUIT00F04', 'Opt. Sea Cargo', 'CC', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_map_service`
--

CREATE TABLE `tb_map_service` (
  `code` varchar(30) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_map_service`
--

INSERT INTO `tb_map_service` (`code`, `name`, `created`, `created_by`) VALUES
('AIR', 'Air Service', NULL, NULL),
('COBA', 'Coba', '2020-11-03 06:48:07', NULL),
('ROAD', 'Transportation', NULL, NULL),
('SEA', 'Sea Service', NULL, NULL),
('WHSE', 'Warehouse', '2020-10-01 11:13:13', 'slamet');

-- --------------------------------------------------------

--
-- Table structure for table `tb_success`
--

CREATE TABLE `tb_success` (
  `id` varchar(15) NOT NULL,
  `code` varchar(20) NOT NULL,
  `proTime` datetime DEFAULT NULL,
  `interfaces` varchar(50) DEFAULT NULL,
  `messages` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_success`
--

INSERT INTO `tb_success` (`id`, `code`, `proTime`, `interfaces`, `messages`) VALUES
('5f75a62b1a1ba', 'IBJKT-REQ-200007', '2020-10-01 16:49:31', 'advance', '{\"item\":{\"TYPE\":\"S\",\"ID\":\"RW\",\"NUMBER\":\"605\",\"MESSAGE\":\"Document posted successfully: BKPFF 9300000152IBTO2019 S4DCLNT320\"}}'),
('5f892803277a2', 'IBJKT-REQ-200007', '2020-10-16 11:56:35', 'advance', 'Document posted successfully: BKPFF 9300000013IBTO2020 S4DCLNT320'),
('5f8a569a18f54', 'IBJKT-REQ-200007', '2020-10-17 09:27:38', 'advance', 'Document posted successfully: BKPFF 9300000014IBTO2020 S4DCLNT320'),
('5f8a6166b8af9', 'IBJKT-REQ-200007', '2020-10-17 10:13:42', 'advance', 'Document posted successfully: BKPFF 9300000015IBTO2020 S4DCLNT320'),
('5f8d284b92783', '2020010120201019', '2020-10-19 12:46:51', 'vendor', '{\"ResponseDetail\":{\"ResponseType\":\"Response\",\"ResponseLevel\":\"Details\",\"RefId\":\"0001000040\",\"Status\":\"Success\"}}'),
('5f8d29d521bc9', '0001000040', '2020-10-19 12:53:25', 'vendor', '{\"ResponseDetail\":{\"ResponseType\":\"Response\",\"ResponseLevel\":\"Details\",\"RefId\":\"0001000040\",\"Status\":\"Success\"}}'),
('5f8d4e8253bb6', '0900000057', '2020-10-19 15:29:54', 'customer', '{\"ResponseDetail\":{\"ResponseType\":\"Response\",\"ResponseLevel\":\"Details\",\"RefId\":\"0900000057\",\"Status\":\"Success\"}}'),
('5f8e6762f0a87', 'IBJKT-REQ-200008', '2020-10-20 11:28:18', 'advance', 'Document posted successfully: BKPFF 9300000016IBTO2020 S4DCLNT320'),
('5f8e6ae8a6920', 'IBJKT-REQ-200009', '2020-10-20 11:43:20', 'advance', 'Document posted successfully: BKPFF 9300000017IBTO2020 S4DCLNT320'),
('5f8e6edc272a6', 'IBJKT-REQ-200010', '2020-10-20 12:00:12', 'advance', 'Document posted successfully: BKPFF 9300000018IBTO2020 S4DCLNT320'),
('5f8e6f1a5d1c3', 'IBJKT-REQ-200011', '2020-10-20 12:01:14', 'advance', 'Document posted successfully: BKPFF 9300000020IBTO2020 S4DCLNT320'),
('5f8e6f809d76e', 'IBJKT-REQ-200012', '2020-10-20 12:02:56', 'advance', 'Document posted successfully: BKPFF 9300000021IBTO2020 S4DCLNT320'),
('5f8fcdc045c70', 'IBJKT-REQ-200015', '2020-10-21 12:57:20', 'advance', 'Document posted successfully: BKPFF 9300000033IBTO2020 S4DCLNT320'),
('5f8fcef15dbe2', 'IBJKT-ARS-200004', '2020-10-21 13:02:25', 'settlment', 'Document posted successfully: BKPFF 9300000035IBTO2020 S4DCLNT320'),
('5f91070449f1b', 'TST-CI-2025566', '2020-10-22 11:13:56', 'payable', 'Document posted successfully: BKPFF 9300000039IBTO2020 S4DCLNT320'),
('5f9123adee0e6', 'IBJKT-IN-2071242', '2020-10-22 13:16:13', 'receivable', 'Document posted successfully: BKPFF 9300000054IBTO2020 S4DCLNT320'),
('5f915836110fc', 'IBJKT-IN-2071242', '2020-10-22 17:00:22', 'receivable', 'Document posted successfully: BKPFF 9300000056IBTO2020 S4DCLNT320'),
('5f9275b3055d8', 'IBJKT-IN-2071247', '2020-10-23 13:18:27', 'receivable', NULL),
('5f9275ec24975', 'IBJKT-IN-2071248', '2020-10-23 13:19:24', 'receivable', 'Document posted successfully: BKPFF 9300000058IBTO2020 S4DCLNT320'),
('5f927ccf618e9', 'TST-CI-2025567', '2020-10-23 13:48:47', 'payable', NULL),
('5f927cf7afc75', 'TST-CI-2025568', '2020-10-23 13:49:27', 'payable', 'Document posted successfully: BKPFF 9300000060IBTO2020 S4DCLNT320'),
('5f927e767774f', 'IBJKT-REQ-200019', '2020-10-23 13:55:50', 'advance', 'Document posted successfully: BKPFF 9300000061IBTO2020 S4DCLNT320'),
('5f9280abe5246', 'IBJKT-ARS-200009', '2020-10-23 14:05:15', 'settlment', 'Document posted successfully: BKPFF 9300000062IBTO2020 S4DCLNT320'),
('5f929a2aa3807', 'IBJKT-ARS-200010', '2020-10-23 15:54:02', 'settlment', 'Document posted successfully: BKPFF 9300000063IBTO2020 S4DCLNT320'),
('5f92d5e712c43', '0900000018', '2020-10-23 20:08:55', 'customer', 'false'),
('5f92d5e82f5f1', '0900000018', '2020-10-23 20:08:56', 'customer', 'false'),
('5f92d5f5aed44', '0900000018', '2020-10-23 20:09:09', 'customer', 'false'),
('5f92d609111a8', '0900000018', '2020-10-23 20:09:29', 'customer', 'false'),
('5f92d7bb3a3a2', '0900000018', '2020-10-23 20:16:43', 'customer', '{\"ResponseDetail\":{\"ResponseType\":\"Response\",\"ResponseLevel\":\"Details\",\"RefId\":\"0900000018\",\"Status\":\"Success\"}}'),
('5f92da029f1da', '0800000100', '2020-10-23 20:26:26', 'vendor', '{\"ResponseDetail\":{\"ResponseType\":\"Response\",\"ResponseLevel\":\"Details\",\"RefId\":\"0800000100\",\"Status\":\"Success\"}}'),
('5f9920b829b49', 'SUIT-SET-2000016', '2020-10-28 14:41:44', 'settlment', 'Document posted successfully: BKPFF 9300000077IBTO2020 S4DCLNT320'),
('5f9920ba25ed2', 'SUIT-SET-2000016', '2020-10-28 14:41:46', 'settlment', 'Document posted successfully: BKPFF 9300000078IBTO2020 S4DCLNT320'),
('5f9922ebadf81', 'SUIT-SET-2000017', '2020-10-28 14:51:07', 'settlment', 'Document posted successfully: BKPFF 9300000079IBTO2020 S4DCLNT320'),
('5f9922ec4913d', 'SUIT-SET-2000017', '2020-10-28 14:51:08', 'settlment', 'Document posted successfully: BKPFF 9300000080IBTO2020 S4DCLNT320'),
('5f9f74a896006', '0900000057', '2020-11-02 09:53:28', 'customer', 'false'),
('5f9f81acd35ad', '2020080120200922', '2020-11-02 10:49:00', 'customer', 'customer'),
('5f9f81c4cce20', '2020080120200922', '2020-11-02 10:49:24', 'customer', 'customer'),
('5f9f8246aa0b7', '2020080120200922', '2020-11-02 10:51:34', 'customer', 'customer'),
('5f9fbcff0b309', 'IBJKT-REQ-200029', '2020-11-02 15:02:07', 'advance', 'Document posted successfully: BKPFF 9300000082IBTO2020 S4DCLNT320'),
('5f9fc3d0b6a01', 'SUIT-SET-2000019', '2020-11-02 15:31:12', 'settlement', 'Document posted successfully: BKPFF 9300000083IBTO2020 S4DCLNT320'),
('5f9fc3d156809', 'SUIT-SET-2000019', '2020-11-02 15:31:13', 'settlment', 'Document posted successfully: BKPFF 9300000084IBTO2020 S4DCLNT320'),
('5f9fcd35e97c3', 'IBJKT-IN-2071240', '2020-11-02 16:11:17', 'receivable', 'Document posted successfully: BKPFF 9300000085IBTO2020 S4DCLNT320'),
('5f9fcd801ab6e', 'IBJKT-IN-2071241', '2020-11-02 16:12:32', 'receivable', 'Document posted successfully: BKPFF 9300000086IBTO2020 S4DCLNT320'),
('5f9fcd9d2bf51', 'IBJKT-IN-2071243', '2020-11-02 16:13:01', 'receivable', 'Document posted successfully: BKPFF 9300000087IBTO2020 S4DCLNT320'),
('5f9fd219042d3', 'TST-CI-2025566', '2020-11-02 16:32:09', 'payable', 'Document posted successfully: BKPFF 9300000088IBTO2020 S4DCLNT320'),
('5fa3697329973', 'IBJKT-REQ-200039', '2020-11-05 09:54:43', 'advance', 'Document posted successfully: BKPFF 9300000089IBTO2020 S4DCLNT320'),
('5fa3a5b2aa839', '0800000100', '2020-11-05 14:11:46', 'customer', 'null'),
('5fa3a60c1c7a2', '0800000100', '2020-11-05 14:13:16', 'customer', 'null'),
('5fa3a8152bed2', '0800000100', '2020-11-05 14:21:57', 'customer', 'null'),
('5fa3ed08def02', '0960000004', '2020-11-05 19:16:08', 'customer', '\"\\u003Cns0:Response xmlns:ns0=\\\"http:\\/\\/Aurionpro.CIPlatform.Schemas.Response\\\"\\u003E\\r\\n  \\u003CResponseDetail\\u003E\\r\\n    \\u003CResponseType\\u003EResponse\\u003C\\/ResponseType\\u003E\\r\\n    \\u003CResponseLevel\\u003EDetails\\u003C\\/ResponseLevel\\u003E\\r\\n    \\u003CRefId\\u003E0960000004\\u003C\\/RefId\\u003E\\r\\n    \\u003CStatus\\u003EFail\\u003C\\/Status\\u003E\\r\\n    \\u003CErrorCode\\u003E0002\\u003C\\/ErrorCode\\u003E\\r\\n    \\u003CErrorDescription\\u003EGenericKey_OfficeDoesNotExists\\u003C\\/ErrorDescription\\u003E\\r\\n  \\u003C\\/ResponseDetail\\u003E\\r\\n\\u003C\\/ns0:Response\\u003E\"'),
('5fa3ed3668d11', '2020080120200922', '2020-11-05 19:16:54', 'customer', '\"\\u003Cns0:Response xmlns:ns0=\\\"http:\\/\\/Aurionpro.CIPlatform.Schemas.Response\\\"\\u003E\\r\\n  \\u003CResponseDetail\\u003E\\r\\n    \\u003CResponseType\\u003EResponse\\u003C\\/ResponseType\\u003E\\r\\n    \\u003CResponseLevel\\u003EDetails\\u003C\\/ResponseLevel\\u003E\\r\\n    \\u003CRefId\\u003E0960000043\\u003C\\/RefId\\u003E\\r\\n    \\u003CStatus\\u003EFail\\u003C\\/Status\\u003E\\r\\n    \\u003CErrorCode\\u003E0002\\u003C\\/ErrorCode\\u003E\\r\\n    \\u003CErrorDescription\\u003EGenericKey_OfficeDoesNotExists\\u003C\\/ErrorDescription\\u003E\\r\\n  \\u003C\\/ResponseDetail\\u003E\\r\\n\\u003C\\/ns0:Response\\u003E\"'),
('5fa3ee45e7b62', '0960000004', '2020-11-05 19:21:25', 'customer', '\"\\u003Cns0:Response xmlns:ns0=\\\"http:\\/\\/Aurionpro.CIPlatform.Schemas.Response\\\"\\u003E\\r\\n  \\u003CResponseDetail\\u003E\\r\\n    \\u003CResponseType\\u003EResponse\\u003C\\/ResponseType\\u003E\\r\\n    \\u003CResponseLevel\\u003EDetails\\u003C\\/ResponseLevel\\u003E\\r\\n    \\u003CRefId\\u003E0960000004\\u003C\\/RefId\\u003E\\r\\n    \\u003CStatus\\u003EFail\\u003C\\/Status\\u003E\\r\\n    \\u003CErrorCode\\u003E0002\\u003C\\/ErrorCode\\u003E\\r\\n    \\u003CErrorDescription\\u003EGenericKey_OfficeDoesNotExists\\u003C\\/ErrorDescription\\u003E\\r\\n  \\u003C\\/ResponseDetail\\u003E\\r\\n\\u003C\\/ns0:Response\\u003E\"'),
('5fa3eee7acfe3', '0960000004', '2020-11-05 19:24:07', 'customer', '<ns0:Response xmlns:ns0=\"http://Aurionpro.CIPlatform.Schemas.Response\">\r\n  <ResponseDetail>\r\n    <ResponseType>Response</ResponseType>\r\n    <ResponseLevel>Details</ResponseLevel>\r\n    <RefId>0960000004</RefId>\r\n    <Status>Fail</Status>\r\n    <ErrorCode>0002</ErrorCode>\r\n    <ErrorDescription>GenericKey_OfficeDoesNotExists</ErrorDescription>\r\n  </ResponseDetail>\r\n</ns0:Response>'),
('5fa3ef6201f89', '0960000004', '2020-11-05 19:26:10', 'customer', '<ns0:Response xmlns:ns0=\"http://Aurionpro.CIPlatform.Schemas.Response\">\r\n  <ResponseDetail>\r\n    <ResponseType>Response</ResponseType>\r\n    <ResponseLevel>Details</ResponseLevel>\r\n    <RefId>0960000004</RefId>\r\n    <Status>Success</Status>\r\n  </ResponseDetail>\r\n</ns0:Response>'),
('5fa3f09f63bf2', '0960000004', '2020-11-05 19:31:27', 'customer', '<ns0:Response xmlns:ns0=\"http://Aurionpro.CIPlatform.Schemas.Response\">\r\n  <ResponseDetail>\r\n    <ResponseType>Response</ResponseType>\r\n    <ResponseLevel>Details</ResponseLevel>\r\n    <RefId>0960000004</RefId>\r\n    <Status>Fail</Status>\r\n    <ErrorCode>0002</ErrorCode>\r\n    <ErrorDescription>GenericKey_OfficeDoesNotExists</ErrorDescription>\r\n  </ResponseDetail>\r\n</ns0:Response>'),
('5fa3fac748621', '0960000004', '2020-11-05 20:14:47', 'customer', '\"\\u003Cns0:Response xmlns:ns0=\\\"http:\\/\\/Aurionpro.CIPlatform.Schemas.Response\\\"\\u003E\\r\\n  \\u003CResponseDetail\\u003E\\r\\n    \\u003CResponseType\\u003EResponse\\u003C\\/ResponseType\\u003E\\r\\n    \\u003CResponseLevel\\u003EDetails\\u003C\\/ResponseLevel\\u003E\\r\\n    \\u003CRefId\\u003E0960000004\\u003C\\/RefId\\u003E\\r\\n    \\u003CStatus\\u003EFail\\u003C\\/Status\\u003E\\r\\n    \\u003CErrorCode\\u003E0002\\u003C\\/ErrorCode\\u003E\\r\\n    \\u003CErrorDescription\\u003EGenericKey_OfficeDoesNotExists\\u003C\\/ErrorDescription\\u003E\\r\\n  \\u003C\\/ResponseDetail\\u003E\\r\\n\\u003C\\/ns0:Response\\u003E\"'),
('5fa3fd497d332', '2020010120201105', '2020-11-05 20:25:29', 'vendor', '\"\\u003Cns0:Response xmlns:ns0=\\\"http:\\/\\/Aurionpro.CIPlatform.Schemas.Response\\\"\\u003E\\r\\n  \\u003CResponseDetail\\u003E\\r\\n    \\u003CResponseType\\u003EResponse\\u003C\\/ResponseType\\u003E\\r\\n    \\u003CResponseLevel\\u003EDetails\\u003C\\/ResponseLevel\\u003E\\r\\n    \\u003CRefId\\u003E0800000103\\u003C\\/RefId\\u003E\\r\\n    \\u003CStatus\\u003EFail\\u003C\\/Status\\u003E\\r\\n    \\u003CErrorCode\\u003E0002\\u003C\\/ErrorCode\\u003E\\r\\n    \\u003CErrorDescription\\u003EGenericKey_OfficeDoesNotExists\\u003C\\/ErrorDescription\\u003E\\r\\n  \\u003C\\/ResponseDetail\\u003E\\r\\n\\u003C\\/ns0:Response\\u003E\"'),
('5fa3fdd0d5241', '2020010120201105', '2020-11-05 20:27:44', 'vendor', '{\"ResponseDetail\":{\"ResponseType\":\"Response\",\"ResponseLevel\":\"Details\",\"RefId\":\"0800000103\",\"Status\":\"Fail\",\"ErrorCode\":\"0002\",\"ErrorDescription\":\"GenericKey_OfficeDoesNotExists\"}}'),
('5fa3ffad90714', '0960000040', '2020-11-05 20:35:41', 'customer', '{\"ResponseDetail\":{\"ResponseType\":\"Response\",\"ResponseLevel\":\"Details\",\"RefId\":\"0960000040\",\"Status\":\"Success\"}}'),
('5fa4006464f29', 'IBJKT-IN-2071268', '2020-11-05 20:38:44', 'receivable', 'Document posted successfully: BKPFF 9300000091IBTO2020 S4DCLNT320'),
('5fa8a65ac7c6e', 'CKIB-AR-20000054', '2020-11-09 09:15:54', 'advance', 'Document posted successfully: BKPFF 9300000000IRBO2020 S4DCLNT320');

-- --------------------------------------------------------

--
-- Table structure for table `tb_token`
--

CREATE TABLE `tb_token` (
  `id` varchar(2) NOT NULL,
  `date` datetime DEFAULT NULL,
  `token_type` varchar(20) DEFAULT NULL,
  `expires_in` datetime DEFAULT NULL,
  `access_token` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_token`
--

INSERT INTO `tb_token` (`id`, `date`, `token_type`, `expires_in`, `access_token`) VALUES
('1', '2020-11-09 12:38:12', 'bearer', '2020-11-10 12:38:12', 'AQAAANCMnd8BFdERjHoAwE_Cl-sBAAAAwDAETyftP0ix_tzL94u1vAAAAAACAAAAAAAQZgAAAAEAACAAAABN11h2FA-FGSAsVskd5BO82EpboZqpNtw18kpmnb6BVAAAAAAOgAAAAAIAACAAAAASZyvgmlfdJCsWUH5AeL8aNfP9I0q4iIzf7S2u2QejIyABAADdgGSarEtGm0nlvzjAMgCTCPALGHyXAk9MXUgH7sHLXvOTs8ecse4Y8rO2YiburgMMjyhx848NITBVwaVP2nwU87x1ogxV2vV5lFpKJlKhHsMXesqvQoxsoCsVykpeyJSnA11kFua9TQtA24SZwTTKsPODH5y26nzvk6CV2P3wUHU_SG_Kc76vOr5xtZANYJWfzGnqkmDpphjMZIeoA3hdYKj76MeDLY7Myfar8RCNKVqLXl83xtivOLgXnHgwDMvNl8cjYRh0fZGE-6fW5iQf0z0fZErA-PkJdUFOCKNi1p99MtTRvd0Hk_i_2Zbm8qUotSt8jiw3lnF2btBLM5-e0MbpSSVJqEKziOHnJM4g3iVXXSwM5UmGdZqUemlqNv1AAAAAmo6argejtdmGXDI-bA8AwAIUBTrPTELRaXLfECwssMFcS8ajIRTBXvsi_8CxiKH0ysIcGmlZBamA7lugq_bJEA');

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `user_id` int(11) NOT NULL,
  `username` varchar(64) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `role` enum('admin','billing','finance','user') NOT NULL DEFAULT 'user',
  `last_login` timestamp NOT NULL DEFAULT current_timestamp(),
  `photo` varchar(64) NOT NULL DEFAULT 'user_no_image.jpg',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified` datetime NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`user_id`, `username`, `password`, `email`, `full_name`, `phone`, `role`, `last_login`, `photo`, `created_at`, `modified`, `is_active`) VALUES
(1, 'slamet', '81dc9bdb52d04dc20036dbd8313ed055', 'slamet@ironbird.co.id', 'Slamet Riyadi', '', 'admin', '2020-09-17 02:18:22', 'user_no_image.jpg', '2020-09-17 02:18:22', '0000-00-00 00:00:00', 1),
(2, 'admin', '81dc9bdb52d04dc20036dbd8313ed055', 'admin@ironbird.co.id', 'Administrator', '', 'admin', '2020-09-17 02:18:22', 'user_no_image.jpg', '2020-09-17 02:18:22', '2020-10-02 16:42:27', 1),
(3, 'ari', '81dc9bdb52d04dc20036dbd8313ed055', 'ari@ironbird.co.id', 'Ari', '', 'billing', '2020-09-18 16:34:19', 'user_no_image.jpg', '2020-09-18 16:34:19', '0000-00-00 00:00:00', 1),
(4, 'angga', '81dc9bdb52d04dc20036dbd8313ed055', '', 'Angga', '', 'billing', '2020-11-06 09:21:06', 'user_no_image.jpg', '2020-11-06 09:21:06', '0000-00-00 00:00:00', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_app_receipt`
--
ALTER TABLE `tb_app_receipt`
  ADD PRIMARY KEY (`code`);

--
-- Indexes for table `tb_app_receipt_items`
--
ALTER TABLE `tb_app_receipt_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_debtor`
--
ALTER TABLE `tb_debtor`
  ADD PRIMARY KEY (`code`);

--
-- Indexes for table `tb_interfaces`
--
ALTER TABLE `tb_interfaces`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_invoice`
--
ALTER TABLE `tb_invoice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_map_config`
--
ALTER TABLE `tb_map_config`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_map_ledger`
--
ALTER TABLE `tb_map_ledger`
  ADD PRIMARY KEY (`code`);

--
-- Indexes for table `tb_map_material`
--
ALTER TABLE `tb_map_material`
  ADD PRIMARY KEY (`code`);

--
-- Indexes for table `tb_map_office`
--
ALTER TABLE `tb_map_office`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_map_pc`
--
ALTER TABLE `tb_map_pc`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_map_posted_cm`
--
ALTER TABLE `tb_map_posted_cm`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_map_profitcost`
--
ALTER TABLE `tb_map_profitcost`
  ADD PRIMARY KEY (`code`);

--
-- Indexes for table `tb_map_service`
--
ALTER TABLE `tb_map_service`
  ADD PRIMARY KEY (`code`);

--
-- Indexes for table `tb_success`
--
ALTER TABLE `tb_success`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_token`
--
ALTER TABLE `tb_token`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_map_config`
--
ALTER TABLE `tb_map_config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_map_office`
--
ALTER TABLE `tb_map_office`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tb_map_pc`
--
ALTER TABLE `tb_map_pc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `tb_map_posted_cm`
--
ALTER TABLE `tb_map_posted_cm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
