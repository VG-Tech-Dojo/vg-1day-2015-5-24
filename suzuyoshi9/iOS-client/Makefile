MOA_XCODEBUILD?=$(shell which xcodebuild)
MOA_SCHEME?="My1DayApp"
MOA_DESTINATION?='platform=iOS Simulator,name=iPhone 6'
MOA_CONFIGURATION?=Test

all:

test:
	$(MOA_XCODEBUILD) \
	-scheme $(MOA_SCHEME) \
	-destination $(MOA_DESTINATION) \
	-configuration $(MOA_CONFIGURATION) \
	test
