<?php
/**
 * @file
 * Template file.
 *
 * @var \EC\Poetry\Services\Plates\Template $this
 * @var string $callback
 */
?><?='<?xml version="1.0" encoding="utf-8"?>'?>
<definitions name="OEPoetryClient"
             targetNamespace="urn:OEPoetryClient"
             xmlns:tns="urn:OEPoetryClient"
             xmlns:xsd="http://www.w3.org/2001/XMLSchema"
             xmlns:soap="http://schemas.xmlsoap.org/wsdl/soap/"
             xmlns:soapenc="http://schemas.xmlsoap.org/soap/encoding/"
             xmlns:wsdl="http://schemas.xmlsoap.org/wsdl/"
             xmlns="http://schemas.xmlsoap.org/wsdl/">
    <message name="OEPoetryClientMessage">
        <part name="user" type="xsd:string" />
        <part name="password" type="xsd:string" />
        <part name="msg" type="xsd:string" />
    </message>
    <message name="OEPoetryClientResponse">
        <part name="return" type="xsd:string" />
    </message>
    <portType name="OEPoetryClientPort">
        <operation name="handle">
            <input message="tns:OEPoetryClientMessage" />
            <output message="tns:OEPoetryClientResponse" />
        </operation>
    </portType>
    <binding name="OEPoetryClientBinding" type="tns:OEPoetryClientPort">
        <soap:binding style="rpc" transport="http://schemas.xmlsoap.org/soap/http" />
        <operation name="handle">
            <soap:operation soapAction="urn:OEPoetryClient#handle" />
            <input>
                <soap:body use="encoded" namespace="urn:OEPoetryClient" encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
            </input>
            <output>
                <soap:body use="encoded" namespace="urn:OEPoetryClient" encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
            </output>
        </operation>
    </binding>
    <service name="OEPoetryClientNotification">
        <port name="OEPoetryClientPort" binding="tns:OEPoetryClientBinding">
            <soap:address location="<?= $callback ?>" />
        </port>
    </service>
</definitions>
