//
//  APIRequestTests.swift
//  My1DayApp
//
//  Created by Sei Takayuki on 2015/05/17.
//  Copyright (c) 2015年 VOYAGE GROUP, inc. All rights reserved.
//

import UIKit
import XCTest

class APIRequestTests: XCTestCase {
    func testBaseURLString() {
        XCTAssertEqual(APIRequest.baseURLString, "http://localhost:8888/")
    }
    
    func testEndpoint() {
        XCTAssertEqual(APIRequest.Endpoint.Messages.rawValue, "messages")
    }
}
