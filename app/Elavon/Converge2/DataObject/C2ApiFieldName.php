<?php

namespace App\Elavon\Converge2\DataObject;

final class C2ApiFieldName extends AbstractEnum
{
    const ACCEPT_HEADER = 'acceptHeader';
    const ACCESS_CONTROL_SERVER_URL = 'accessControlServerUrl';
    const ACCOUNT_NUMBER = 'accountNumber';
    const ADDRESS_POSTAL_CODE = 'addressPostalCode';
    const ADDRESS_STREET = 'addressStreet';
    const ALTERNATE_PHONE = 'alternatePhone';
    const AMOUNT = 'amount';
    const API_VERSION = 'apiVersion';
    const AUTHENTICATION_VALUE = 'authenticationValue';
    const AUTHORIZATION_CODE = 'authorizationCode';
    const BASIC_AUTHENTICATION_CREDENTIALS = 'basicAuthenticationCredentials';
    const BATCH = 'batch';
    const BILL_COUNT = 'billCount';
    const BILL_TO = 'billTo';
    const BILLING_INTERVAL = 'billingInterval';
    const BIN = 'bin';
    const BLIK = 'blik';
    const BRAND = 'brand';
    const BUSINESS_ADDRESS = 'businessAddress';
    const BUSINESS_EMAIL = 'businessEmail';
    const BUSINESS_PHONE = 'businessPhone';
    const BUSINESS_WEBSITE = 'businessWebsite';
    const CANCELLED_AT = 'cancelledAt';
    const CANCEL_AFTER_BILL_NUMBER = 'cancelAfterBillNumber';
    const CANCEL_REQUESTED_AT = 'cancelRequestedAt';
    const CANCEL_URL = 'cancelUrl';
    const CARD = 'card';
    const CARD_NUMBER = 'cardNumber';
    const CITY = 'city';
    const CLICK_COUNT = 'clickCount';
    const CODE = 'code';
    const COMPANY = 'company';
    const CONVERSION_COUNT = 'conversionCount';
    const CONVERSION_LIMIT = 'conversionLimit';
    const CONVERSION_RATE = 'conversionRate';
    const COUNT = 'count';
    const COUNTRY_CODE = 'countryCode';
    const CREATED_AT = 'createdAt';
    const CREATED_BY = 'createdBy';
    const CREDITS = 'credits';
    const CURRENCY_CODE = 'currencyCode';
    const CUSTOM_REFERENCE = 'customReference';
    const CUSTOM_FIELDS = 'customFields';
    const DATE_OF_BIRTH = 'dateOfBirth';
    const DEBITS = 'debits';
    const DEBTOR_ACCOUNT = 'debtorAccount';
    const DEFAULT_STORED_CARD = 'defaultStoredCard';
    const DEFAULT_LANGUAGE_TAG = 'defaultLanguageTag';
    const DELETED_AT = 'deletedAt';
    const DESCRIPTION = 'description';
    const DIRECTORY_SERVER_TRANSACTION_ID = 'directoryServerTransactionId';
    const DO_CANCEL = 'doCancel';
    const DO_CAPTURE = 'doCapture';
    const DO_CREATE_TRANSACTION = 'doCreateTransaction';
    const DO_FOREX_CONVERSION = 'doForexConversion';
    const DO_SEND_RECEIPT = 'doSendReceipt';
    const DO_THREE_D_SECURE = 'doThreeDSecure';
    const DO_VERIFY = 'doVerify';
    const ELECTRONIC_COMMERCE_INDICATOR = 'electronicCommerceIndicator';
    const EMAIL = 'email';
    const EVENT_TYPE = 'eventType';
    const EXPIRATION_MONTH = 'expirationMonth';
    const EXPIRATION_YEAR = 'expirationYear';
    const EXPIRES_AT = 'expiresAt';
    const FAILURES = 'failures';
    const FAILURE_COUNT = 'failureCount';
    const FAX = 'fax';
    const FIELD = 'field';
    const FINAL_BILL_AT = 'finalBillAt';
    const FIRST = 'first';
    const FIRST_BILL_AT = 'firstBillAt';
    const FOREX_ADVICE = 'forexAdvice';
    const FULL_NAME = 'fullName';
    const FUNDING_SOURCE = 'fundingSource';
    const HISTORY = 'history';
    const HOLDER_NAME = 'holderName';
    const HOSTED_CARD = 'hostedCard';
    const HREF = 'href';
    const HPP_TYPE = 'hppType';
    const ID = 'id';
    const INITIAL_TOTAL = 'initialTotal';
    const INITIAL_TOTAL_BILL_COUNT = 'initialTotalBillCount';
    const IS_AUTHORIZED = 'isAuthorized';
    const IS_CORPORATE = 'isCorporate';
    const IS_DCC_ALLOWED = 'isDccAllowed';
    const IS_DEBIT = 'isDebit';
    const IS_ENABLED = 'isEnabled';
    const IS_HELD_FOR_REVIEW = 'isHeldForReview';
    const IS_SUBSCRIBABLE = 'isSubscribable';
    const IS_SUCCESSFUL = 'isSuccessful';
    const IS_SUPPORTED = 'isSupported';
    const ISSUER_REFERENCE = 'issuerReference';
    const ISSUER_TOTAL = 'issuerTotal';
    const ISSUING_BANK = 'issuingBank';
    const ISSUING_COUNTRY = 'issuingCountry';
    const ISSUING_CURRENCY = 'issuingCurrency';
    const ITEMS = 'items';
    const LAST_4 = 'last4';
    const LAST_NAME = 'lastName';
    const LEGAL_NAME = 'legalName';
    const LIMIT = 'limit';
    const MARKUP_RATE = 'markupRate';
    const MARKUP_RATE_ANNOTATION = 'markupRateAnnotation';
    const MASKED_NUMBER = 'maskedNumber';
    const MERCHANT = 'merchant';
    const MERCHANT_CATEGORY_CODE = 'merchantCategoryCode';
    const MODIFIED_AT = 'modifiedAt';
    const NAME = 'name';
    const NET = 'net';
    const NEXT = 'next';
    const NEXT_BILL_AT = 'nextBillAt';
    const NEXT_BILL_NUMBER = 'nextBillNumber';
    const NEXT_PAGE_TOKEN = 'nextPageToken';
    const NUMBER = 'number';
    const ORDER = 'order';
    const ORDER_REFERENCE = 'orderReference';
    const ORIGIN_URL = 'originUrl';
    const PAGE_TOKEN = 'pageToken';
    const PAN_FINGERPRINT = 'panFingerprint';
    const PAN_TOKEN = 'panToken';
    const PARENT_TRANSACTION = 'parentTransaction';
    const PASSWORD = 'password';
    const PAYER_AUTHENTICATION_REQUEST = 'payerAuthenticationRequest';
    const PAYER_AUTHENTICATION_RESPONSE = 'payerAuthenticationResponse';
    const PAYMENT_LINK = 'paymentLink';
    const PAYMENT_SESSION = 'paymentSession';
    const PHONE = 'phone';
    const PLAN = 'plan';
    const POSTAL_CODE = 'postalCode';
    const PREVIOUS_BILL_AT = 'previousBillAt';
    const PREVIOUS_RECURRING_TRANSACTION = 'previousRecurringTransaction';
    const PRIMARY_ADDRESS = 'primaryAddress';
    const PRIMARY_PHONE = 'primaryPhone';
    const PROCESSOR_ACCOUNT = 'processorAccount';
    const PROCESSOR_REFERENCE = 'processorReference';
    const PROTOCOL_VERSION = 'protocolVersion';
    const PROVIDER = 'provider';
    const QUANTITY = 'quantity';
    const RECURRING_TYPE = 'recurringType';
    const REGION = 'region';
    const RELATED_TRANSACTIONS = 'relatedTransactions';
    const RESOURCE = 'resource';
    const RESOURCE_TYPE = 'resourceType';
    const RETURN_URL = 'returnUrl';
    const SCHEME = 'scheme';
    const SECRET = 'secret';
    const SECURITY_CODE = 'securityCode';
    const SETTLEMENT_CURRENCY_CODE = 'settlementCurrencyCode';
    const SHIP_TO = 'shipTo';
    const SHOPPER = 'shopper';
    const SHOPPER_EMAIL_ADDRESS = 'shopperEmailAddress';
    const SHOPPER_INTERACTION = 'shopperInteraction';
    const SHOPPER_IP_ADDRESS = 'shopperIpAddress';
    const SHOPPER_LANGUAGE_TAG = 'shopperLanguageTag';
    const SHOPPER_REFERENCE = 'shopperReference';
    const SHOPPER_STATEMENT = 'shopperStatement';
    const SHOPPER_TIME_ZONE = 'shopperTimeZone';
    const SIZE = 'size';
    const SOURCE = 'source';
    const STATE = 'state';
    const STORED_CARD = 'storedCard';
    const STREET_1 = 'street1';
    const STREET_2 = 'street2';
    const SUBSCRIPTION = 'subscription';
    const SUBSCRIPTION_STATE = 'subscriptionState';
    const SUPPORTED_CARD_BRANDS = 'supportedCardBrands';
    const THREE_D_SECURE = 'threeDSecure';
    const THREE_D_SECURE_V1 = 'threeDSecureV1';
    const THREE_D_SECURE_V2 = 'threeDSecureV2';
    const TIME_UNIT = 'timeUnit';
    const TIME_ZONE_ID = 'timeZoneId';
    const TOKEN = 'token';
    const TOTAL = 'total';
    const TOTAL_REFUNDED = 'totalRefunded';
    const TRADE_NAME = 'tradeName';
    const TRANSACTION = 'transaction';
    const TRANSACTION_STATUS = 'transactionStatus';
    const TYPE = 'type';
    const UNIT_PRICE = 'unitPrice';
    const URL = 'url';
    const USER_AGENT = 'userAgent';
    const USERNAME = 'username';
    const VERIFICATION_RESULTS = 'verificationResults';
    const VERSION = 'version';
    const WEBHOOK = 'webhook';
}
