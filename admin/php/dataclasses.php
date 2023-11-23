<?php

// objects for "users" table in db
class User {
    private $userID;
    private $firstName;
    private $lastName;
    private $password;
    private $userRole;
    private $status;

    public function __construct($userID, $firstName, $lastName, $password, $userRole, $status) {
        $this->userID = $userID;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->password = $password;
        $this->userRole = $userRole;
        $this->status = $status;
    }

    public function get_userID() {
        return $this->userID;
    }

    public function get_firstName() {
        return $this->firstName;
    }

    public function get_lastName() {
        return $this->lastName;
    }

    public function get_password() {
        return $this->password;
    }

    public function get_userRole() {
        return $this->userRole;
    }

    public function get_status() {
        return $this->status;
    }
}

// objects for "requests" table in db
class Request {
    private $requestID;
    private $officeID;
    private $userID;
    private $documentID;
    private $dataSubmitted;
    private $overallStatus;

    public function __construct($requestID, $officeID, $userID, $documentID, $dataSubmitted, $overallStatus) {
        $this->requestID = $requestID;
        $this->officeID = $officeID;
        $this->userID = $userID;
        $this->documentID = $documentID;
        $this->dataSubmitted = $dataSubmitted;
        $this->overallStatus = $overallStatus;
    }

    public function get_requestID() {
        return $this->requestID;
    }

    public function get_officeID() {
        return $this->officeID;
    }

    public function get_userID() {
        return $this->userID;
    }

    public function get_documentID() {
        return $this->documentID;
    }

    public function get_dataSubmitted() {
        return $this->dataSubmitted;
    }

    public function get_overallStatus() {
        return $this->overallStatus;
    }
}

// objects for "documents" table in db
class Document {
    private $documentID;
    private $documentTitle;
    private $documentType;
    private $numberOfPages;
    private $documentPath;
    private $comment;
    private $dataReceived;
    private $dataReviewed;
    private $status;

    public function __construct($documentID, $documentTitle, $documentType, $numberOfPages, $documentPath, 
                                $comment, $dataReceived, $dataReviewed, $status) {
        $this->documentID = $documentID;
        $this->documentTitle = $documentTitle;
        $this->documentType = $documentType;
        $this->numberOfPages = $numberOfPages;
        $this->documentPath = $documentPath;
        $this->comment = $comment;
        $this->dataReceived = $dataReceived;
        $this->dataReviewed = $dataReviewed;
        $this->status = $status;
    }

    public function get_documentID() {
        return $this->documentID;
    }

    public function get_documentTitle() {
        return $this->documentTitle;
    }

    public function get_documentType() {
        return $this->documentType;
    }

    public function get_numberOfPages() {
        return $this->numberOfPages;
    }

    public function get_documentPath() {
        return $this->documentPath;
    }

    public function get_comment() {
        return $this->comment;
    }

    public function get_dataReceived() {
        return $this->dataReceived;
    }

    public function get_dataReviewed() {
        return $this->dataReviewed;
    }

    public function get_status() {
        return $this->status;
    }
}

// objects for "offices" table in db
class Office {
    private $officeID;
    private $officeName;
    private $officeEmail;

    public function __construct($officeID, $officeName, $officeEmail) {
        $this->officeID = $officeID;
        $this->officeName = $officeName;
        $this->officeEmail = $officeEmail;
    }

    public function get_officeID() {
        return $this->officeID;
    }

    public function get_officeName() {
        return $this->officeName;
    }

    public function get_officeEmail() {
        return $this->officeEmail;
    }
}
?>
